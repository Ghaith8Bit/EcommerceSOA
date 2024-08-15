<?php

namespace App\Services\Order\Facades;

use App\Services\Order\Services\OrderService;
use Illuminate\Support\Facades\Facade;

class OrderFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return OrderService::class;
    }
}
