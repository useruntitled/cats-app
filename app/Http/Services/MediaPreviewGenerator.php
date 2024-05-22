<?php

namespace App\Http\Services;

use FFMpeg\Coordinate\TimeCode;
use FFMpeg\FFMpeg;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Encoders\JpegEncoder;
use Intervention\Image\ImageManager;

class MediaPreviewGenerator
{
    public static function make(string $path, string $format, bool $isVideo): string
    {
        if (! $isVideo) {
            $imageInterface = ImageManager::imagick()->read($path);
            if ($format != 'gif') {
                try {
                    $imageInterface = $imageInterface
                        ->scaleDown(config('media.previewWidth'), config('media.previewHeight'))
                        ->blur(config('media.blur'))
                        ->encodeByMediaType();
                } catch (\Exception $e) {
                    $imageInterface = $imageInterface
                        ->scaleDown(config('media.previewWidth'), config('media.previewHeight'))
                        ->blur(config('media.blur'))
                        ->toJpeg();
                }

                return 'data:image/'.$format.';base64,'.base64_encode($imageInterface);
            }

            $imageInterface = $imageInterface
                ->removeAnimation('50%')
                ->scaleDown(config('media.previewWidth'))
                ->blur(config('media.blur'))
                ->encode(new JpegEncoder());

            return 'data:image/'.'jpeg'.';base64,'.base64_encode($imageInterface);
        }

        $ffmpeg = FFMpeg::create(MediaConverter::$ffmpegConfiguration);

        $video = $ffmpeg->open($path);

        $duration = $video->getStreams()->videos()->first()->get('duration');

        $frame = $video->frame(TimeCode::fromSeconds($duration / 2));

        $hashName = md5($path);
        Storage::disk('media')->put($hashName.".$format", file_get_contents($path));

        $outputPath = Storage::disk('media')->path($hashName.".$format");

        $frame->save($outputPath);

        $imageInterface = ImageManager::imagick()->read($outputPath);

        $imageInterface = $imageInterface
            ->scaleDown(config('media.previewWidth'), config('media.previewHeight'))
            ->blur(config('media.blur'))
            ->encodeByMediaType();

        $base64 = base64_encode($imageInterface);

        unlink($outputPath);

        return 'data:image/jpeg;base64,'.$base64;
    }
}
