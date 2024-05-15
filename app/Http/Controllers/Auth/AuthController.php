<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function me()
    {
        if (! auth()->user()) {
            return response(['message' => 'Unauthorized'], 401);
        }

        return response()->json(UserResource::make(auth()->user()));
    }

    public function register(RegisterRequest $request)
    {
        $password = Hash::make($request->password);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $password,
        ]);

        return response()->json([
            'message' => 'User is created.',
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        $token = auth()->attempt($request->validated());

        if (! $token) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token, [
            'user' => auth()->user(),
        ]);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    protected function respondWithToken($token, $data = [])
    {
        return response()->json([
            ...$data,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
        ], 200);
    }
}
