<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\JwtService;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OAT;

class LogoutController extends Controller
{
    public function __construct(private JwtService $jwtService)
    {
    }

    #[OAT\Post(
        tags: ['auth'],
        path: '/api/auth/logout',
        summary: 'Logout a user',
        operationId: 'api.auth.logout',
        requestBody: new OAT\RequestBody(
            required: true,
        ),
        responses: [
            new OAT\Response(
                response: 200,
                description: 'Ok',
            )]
    )]
    public function __invoke(): JsonResponse
    {
        $this->jwtService->invalidateToken();

        return response()->json([
            'status' => 'success',
            'message' => 'Logged out successfully.',
        ]);
    }
}
