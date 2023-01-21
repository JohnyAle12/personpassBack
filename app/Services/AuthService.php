<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use Illuminate\Http\JsonResponse;

class AuthService
{
    public function responseToken(User $user): JsonResponse
    {
        return response()->json([
            'user' => $user,
            'access_token' => $user->createToken('auth')->plainTextToken,
            'token_type' => 'Bearer'
        ]);
    }
}