<?php

namespace App\Services\Auth;

use Illuminate\Http\JsonResponse;

class AuthService
{
    public function login($credentials): JsonResponse
    {
        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Falha ao autenticar, tente novamente.'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function logout(): JsonResponse
    {
        auth()->logout();
        return response()->json(['message' => 'Deslogado com sucesso']);
    }

    public function refresh(): JsonResponse
    {
        $token = auth()->refresh();
        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
