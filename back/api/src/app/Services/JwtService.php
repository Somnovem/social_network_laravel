<?php

namespace App\Services;

use App\Http\Resources\Auth\SuccessLoginResource;
use Illuminate\Support\Facades\Auth;

class JwtService
{

    public function guardApi(array $data)
    {
        $token = Auth::guard('api')->attempt($data);
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
        return new SuccessLoginResource(
            [
                'status' => 'success',
                'user' => $user,
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ]
        );
    }

    public function invalidateToken(): void
    {
        if (Auth::guard('api')->hasUser()) {
            Auth::guard('api')->logout();
        }
    }
}
