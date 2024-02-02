<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\JwtService;
use Illuminate\Http\JsonResponse;

class LogoutController extends Controller
{
    public function __construct(private JwtService $jwtService)
    {
    }

    public function __invoke(): JsonResponse
    {
        // Attempt to invalidate the current token
        $this->jwtService->invalidateToken();

        // Return a success response indicating the user has been logged out
        return response()->json([
            'status' => 'success',
            'message' => 'Logged out successfully.',
        ]);
    }
}
