<?php

namespace App\Services\Auth\Providers;

use App\Services\Auth\Models\User;
use App\Services\Auth\Repositories\AuthRepository;
use App\Services\Auth\Services\AuthService;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    public function register()
    {

        $this->app->singleton(AuthRepository::class, function ($app) {
            return new AuthRepository(
                $app->make(User::class)
            );
        });

        $this->app->singleton(AuthService::class, function ($app) {
            return new AuthService(
                $app->make(AuthRepository::class)
            );
        });
    }

    public function boot()
    {
        // You can add any bootstrapping logic here
    }
}
