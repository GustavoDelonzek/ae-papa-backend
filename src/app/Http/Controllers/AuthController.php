<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Resources\UserResource;
use App\Http\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(
        private AuthService $authService
    ){
    }

    public function register(RegisterUserRequest $request)
    {
        $result = $this->authService->registerUser($request->validated());

        return response()->json([
            'user' => new UserResource($result['user']),
            'token' => $result['token']
        ], 201);
    }

    public function login(LoginUserRequest $request)
    {
        $result = $this->authService->loginUser($request->validated());

        if(!$result['user']){
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        return response()->json([
            'user' => new UserResource($result['user']),
            'token' => $result['token']
        ], 200);
    }

    public function logout(Request $request)
    {
        $this->authService->logoutUser($request->user());

        return response()->json([
            'message' => 'Successfully logged out'
        ], 200);
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $this->authService->sendPasswordResetLink($request->validated());

        return response()->json([
            'message' => 'Password reset link sent if email exists'
        ], 200);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $this->authService->resetPassword($request->validated());

        return response()->json([
            'message' => 'Password has been reset successfully'
        ], 200);
    }
}
