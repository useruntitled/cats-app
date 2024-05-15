<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAvatarRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index($userId)
    {
        $user = User::findOrFail($userId);

        return response()->json(UserResource::make($user));
    }

    public function storeAvatar(Request $request)
    {
        return response()->json($request->all());
    }
}
