<?php

namespace App\Services\Auth\Facades;

use App\Services\Auth\Services\AuthService;
use Illuminate\Support\Facades\Facade;

class AuthFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return AuthService::class;
    }
}
