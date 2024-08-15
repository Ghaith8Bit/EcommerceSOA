<?php

namespace App\Services\Product\Contracts;

use App\Services\Product\DTOs\ProductDTO;

interface ProductContract
{
    public function getAll();

    public function getById($id);

    public function create(ProductDTO $dto);

    public function update($id, ProductDTO $dto);

    public function delete($id);
}
