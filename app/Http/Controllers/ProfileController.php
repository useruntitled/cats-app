<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAvatarRequest;
use App\Http\Resources\MediaResource;
use App\Http\Resources\PostResource;
use App\Http\Resources\UserResource;
use App\Http\Services\MediaUploader;
use App\Models\Media;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index($userId)
    {
        $user = User::findOrFail($userId);

        return response()->json(UserResource::make($user));
    }

    public function storeAvatar(StoreAvatarRequest $request)
    {
        $media = Media::findOrFail($request->uuid);

        auth()->user()->avatar()->save($media);

        return response()->json(MediaResource::make($media), 201);
    }

    public function getPosts($id)
    {
        $user = User::findOrFail($id);

        return response()->json(PostResource::collection($user->posts));
    }
}
