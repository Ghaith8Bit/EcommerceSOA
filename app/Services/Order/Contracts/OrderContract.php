<?php

namespace App\Services\Order\Contracts;

use App\Services\Order\DTOs\OrderDTO;

interface OrderContract
{
    public function getAll();
    public function getById(int $id);
    public function createOrder(OrderDTO $dto);
}
