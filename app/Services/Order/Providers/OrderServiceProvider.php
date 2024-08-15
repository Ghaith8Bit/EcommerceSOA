<?php

namespace App\Services\Order\Providers;

use App\Services\Order\Models\Order;
use App\Services\Order\Repositories\OrderRepository;
use App\Services\Order\Services\OrderService;
use Illuminate\Support\ServiceProvider;

class OrderServiceProvider extends ServiceProvider
{
    public function register()
    {

         $this->app->singleton(OrderRepository::class, function ($app) {
            return new OrderRepository(
                $app->make(Order::class)
            );
        });

        $this->app->singleton(OrderService::class, function ($app) {
            return new OrderService(
                $app->make(OrderRepository::class)
            );
        });
    }

    public function boot()
    {
        // You can add any bootstrapping logic here
    }
}
