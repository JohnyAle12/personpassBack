<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
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
    
            $token = $user->createToken('auth')->plainTextToken;
    
            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer'
            ], 200);
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
        $token = $user->createToken('auth')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

    public function getUser(Request $request): User
    {
        return $request->user();
    }
}
