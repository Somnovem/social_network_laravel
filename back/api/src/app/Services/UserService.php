<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Model;

class UserService
{
    public function __construct(private UserRepository $userRepository){}

    public function create(array $data): Model
    {
        return $this->userRepository->create($data);
    }

}
