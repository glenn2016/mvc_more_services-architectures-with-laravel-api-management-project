<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    //

    public function register(array $data)
    {
        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'created_by' => Auth::id(), // Le chef qui crée le membre
        ]);

        return $user;

    }

    public function login(array $credentials)
    {
        if (! $token = JWTAuth::attempt($credentials)) {
            return null;
        }

        return $token;
    }


    public function me()
    {
        return Auth::user();
    }

    public function logout()
    {
        Auth::logout();
    }
}
