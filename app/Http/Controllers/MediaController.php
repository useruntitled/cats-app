<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMediaRequest;
use App\Http\Services\MediaConverter;
use App\Http\Services\MediaPreviewGenerator;
use App\Http\Services\MediaReader;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function index($uuid)
    {
        $result = Cache::remember("image:$uuid", now()->addDays(7), function () use ($uuid) {
            $media = Media::findOrFail($uuid);

            $type = $media->isVideo ? 'video' : 'image';

            return response(file_get_contents(Storage::disk('media')->path($uuid.'.'.$media->format)))
                ->header('Content-Type', "$type/$media->format")
                ->header('Content-Disposition', 'inline')
                ->header('X-Content-Type-Options', 'nosniff');
        });

        return $result;
    }

    public function store(StoreMediaRequest $request, MediaReader $reader)
    {
        $uploadedFile = $request->file('file');

        $reader->setFile($uploadedFile);

        $format = $reader->getFormat();

        Storage::disk('media')->put($reader->uuid.'.'.$format, file_get_contents($uploadedFile));
        $path = Storage::disk('media')->path($reader->uuid.'.'.$format);

        if ($reader->getFormat() == 'gif') {
            MediaConverter::fromGifToMp4($path);
        }

        $base64Preview = MediaPreviewGenerator::make($reader->getPathName(), $format, $reader->isVideo());

        if ($reader->getFormat() == 'gif') {
            $format = 'mp4';
        }

        $isVideo = $format == 'mp4' || $reader->isVideo();
        $media = Media::create([
            'uuid' => $reader->uuid,
            'user_id' => Auth::id(),
            'width' => $reader->getWidth(),
            'height' => $reader->getHeight(),
            'format' => $format,
            'href' => route('media.view', $reader->uuid),
            'base64_preview' => $base64Preview,
            'is_video' => $isVideo,
        ]);

        return response()->json($media, 201);
    }

    public function destroy(Request $request)
    {
        Media::destroy($request->uuid);

        return response()->json('', 204);
    }
}
