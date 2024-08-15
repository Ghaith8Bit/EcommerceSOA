<?php

namespace App\Services\Order\DTOs;

use App\Support\DTO;

class OrderDTO extends DTO
{
    public $user_id;
    public $products;

    protected static function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ];
    }
}
