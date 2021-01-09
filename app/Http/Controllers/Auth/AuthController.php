<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthLoginRequest;
use App\Services\Auth\AuthService;
use Exception;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    private $authService;

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
        $this->authService = app(AuthService::class);
    }

    public function login(AuthLoginRequest $request): JsonResponse
    {
        try {
            $credentials = $request->all(['email', 'password']);
            $response = $this->authService->login($credentials);

        } catch (Exception $exception) {
            $response = response()->json([
                'message' => 'Ocorreu um erro interno'
            ], 500);
        }

        return $response;
    }

    public function logout(): JsonResponse
    {
        try {
            $response = $this->authService->logout();

        } catch (Exception $e) {
            $response = response()->json([
                'message' => 'Ocorreu um erro interno'
            ], 500);
        }

        return $response;
    }

    public function refresh(): JsonResponse
    {
        try {
            $response = $this->authService->refresh();

        } catch (Exception $e) {
            $response = response()->json([
                'message' => 'Ocorreu um erro interno'
            ], 500);
        }

        return $response;
    }

}
