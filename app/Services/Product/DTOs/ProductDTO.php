<?php

namespace App\Services\Product\DTOs;

use App\Support\DTO;

class ProductDTO extends DTO
{
    public $name;
    public $description;
    public $price;
    public $quantity;

    protected static function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
        ];
    }
}
