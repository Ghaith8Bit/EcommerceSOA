<?php

namespace App\Services\Product\Providers;

use App\Services\Product\Models\Product;
use App\Services\Product\Repositories\ProductRepository;
use App\Services\Product\Services\ProductService;
use Illuminate\Support\ServiceProvider;

class ProductServiceProvider extends ServiceProvider
{
    public function register()
    {

        $this->app->singleton(ProductRepository::class, function ($app) {
            return new ProductRepository(
                $app->make(Product::class)
            );
        });

        $this->app->singleton(ProductService::class, function ($app) {
            return new ProductService(
                $app->make(ProductRepository::class)
            );
        });
    }

    public function boot()
    {
        // You can add any bootstrapping logic here
    }
}
