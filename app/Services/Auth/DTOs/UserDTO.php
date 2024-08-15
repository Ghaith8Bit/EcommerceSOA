<?php

namespace App\Services\Auth\DTOs;

use App\Support\DTO;

class UserDTO extends DTO
{
    public $name;
    public $email;
    public $password;

    protected static function rules(): array
    {
        return [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6',
        ];
    }
}
