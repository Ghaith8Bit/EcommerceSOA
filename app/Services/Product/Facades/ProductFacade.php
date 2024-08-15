<?php

namespace App\Services\Product\Facades;

use App\Services\Product\Services\ProductService;
use Illuminate\Support\Facades\Facade;


class ProductFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ProductService::class;
    }
}
