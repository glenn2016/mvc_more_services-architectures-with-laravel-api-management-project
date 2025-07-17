<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //

    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string',
            'email'    => 'required|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = $this->authService->register($request->all());

        return response()->json([
            'message' => 'Utilisateur créé avec succès',
            'user'    => $user
        ]);
    }

    /**
     * @group Authentification
     * Connexion d’un utilisateur
     *
     * Ce endpoint permet à un utilisateur de se connecter et de recevoir un token JWT.
     *
     * @bodyParam email string required L’email de l’utilisateur. Example: john@example.com
     * @bodyParam password string required Le mot de passe. Example: secret123
     *
     * @response 200 {
     *  "access_token": "eyJ0eXAiOiJKV1QiLCJh...",
     *  "token_type": "bearer",
     *  "expires_in": 3600
     * }
     */

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $token = $this->authService->login($credentials);

        if (! $token) {
            return response()->json(['error' => 'Identifiants invalides'], 401);
        }

        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth()->factory()->getTTL() * 60
        ]);
    }

    public function me()
    {
        return response()->json($this->authService->me());
    }

    public function logout()
    {
        $this->authService->logout();

        return response()->json(['message' => 'Déconnexion réussie']);
    }
}
