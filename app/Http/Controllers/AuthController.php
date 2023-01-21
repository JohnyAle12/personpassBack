<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Events\UserProcessed;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct(
        private AuthService $authService
    ) {
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'lastname' => $request->lastname,
                'mobile' => $request->mobile,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            event(new UserProcessed($user));

            return $this->authService->responseToken($user);
        } catch (\Exception $ex) {
            return response()->json($ex);
        }
    }

    public function login(Request $request): JsonResponse
    {
        if(!Auth::attempt($request->only('email', 'password'))){
            return response()->json([
                'message' => 'Invalid login request',
            ], 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();

        return $this->authService->responseToken($user);
    }

    public function getUser(Request $request): User
    {
        return $request->user();
    }
}
