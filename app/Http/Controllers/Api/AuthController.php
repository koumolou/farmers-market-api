<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Responses\ApiResponse;
use App\Services\AuthService;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService) {}

    public function login(LoginRequest $request)
    {
        $result = $this->authService->login($request->validated());
        return ApiResponse::success($result, 'Login successful');
    }

    public function logout()
    {
        $this->authService->logout(auth()->user());
        return ApiResponse::success(null, 'Logged out successfully');
    }

    public function me()
    {
        return ApiResponse::success(auth()->user());
    }
}