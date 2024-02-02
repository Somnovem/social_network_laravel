<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\JwtService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function __construct(
        private UserService $userService,
        private JwtService $jwtService,
    )
    {
    }

    public function __invoke(RegisterRequest $request): JsonResponse
    {
        $this->userService->create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ]);
        $token = $this->jwtService->guardApi([
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ]);

        return $this->jwtService->buildResponse($token);
    }

}
