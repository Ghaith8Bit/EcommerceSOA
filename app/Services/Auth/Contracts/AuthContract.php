<?php

namespace App\Services\Auth\Contracts;

use App\Services\Auth\DTOs\AuthDTO;
use App\Services\Auth\DTOs\UserDTO;

interface AuthContract
{
    public function register(UserDTO $dto);

    public function login(AuthDTO $dto);
}
