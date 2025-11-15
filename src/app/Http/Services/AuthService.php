<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use App\Jobs\SendForgotPasswordMail;
use Illuminate\Validation\ValidationException;

readonly class AuthService
{
    public function registerUser(array $data): array
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $token = auth('api')->login($user);

        return [
            'user' => $user,
            'token' => $token,
        ];
     }

    public function loginUser(array $data): array
    {
        $token = auth('api')->attempt([
            'email' => $data['email'],
            'password' => $data['password'],
        ]);

        if (! $token) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return [
            'user' => auth('api')->user(),
            'token' => $token,
        ];
    }

    public function logoutUser(User $user): void
    {
        auth('api')->logout($user);
    }

    public function sendPasswordResetLink(array $data): void
    {
        $user = User::where('email', $data['email'])->first();

        if ($user) {
            $token = Password::createToken($user);

            SendForgotPasswordMail::dispatch($user->email, $token);
        }
    }

    public function resetPassword(array $data): void
    {
        $status = Password::reset(
            [
                'email' => $data['email'],
                'password' => $data['password'],
                'token' => $data['token'],
            ],
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();
            }
        );

        if ($status !== Password::PASSWORD_RESET) {
            throw ValidationException::withMessages([
                'email' => [__($status)],
            ]);
        }
    }
}
