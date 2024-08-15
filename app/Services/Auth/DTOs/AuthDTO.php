<?php

namespace App\Services\Auth\DTOs;

use App\Support\DTO;

class AuthDTO extends DTO
{
    public $email;
    public $password;

    protected static function rules(): array
    {
        return [
            'email' => 'required|string|email',
            'password' => 'required|string|min:6',
        ];
    }
}
