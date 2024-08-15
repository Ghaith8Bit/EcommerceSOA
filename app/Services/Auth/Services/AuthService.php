<?php

namespace App\Services\Auth\Services;

use App\Services\Auth\Repositories\AuthRepository;
use App\Services\Auth\DTOs\AuthDTO;
use App\Services\Auth\Contracts\AuthContract;
use App\Services\Auth\DTOs\UserDTO;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService implements AuthContract
{
    protected $authRepo;

    public function __construct(AuthRepository $authRepo)
    {
        $this->authRepo = $authRepo;
    }

    public function register(UserDTO $dto)
    {
        return $this->authRepo->create($dto->toArray());
    }
    public function login(AuthDTO $dto)
    {
        if (!$token = JWTAuth::attempt($dto->toArray())) {
            return false;
        }

        return $token;
    }
}
