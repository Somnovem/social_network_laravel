<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
//use Tymon\JWTAuth\Facades\JWTAuth;

class JwtService
{

    public function guardApi(array $data)
    {
        $token = Auth::guard('api')->attempt($data);
        info($token);
        return $token;
    }

    public function buildResponse(string|null $token)
    {
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::guard('api')->user();
        return response()->json([
            'status' => 'success',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function invalidateToken(): void
    {
        // Retrieve the currently authenticated user
        $user = Auth::guard('api')->user();

        // Invalidate the token for the user
        if ($user) {
            //JWTAuth::invalidate(JWTAuth::getToken());
        }
    }
}
