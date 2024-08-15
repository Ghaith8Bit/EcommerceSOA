<?php

namespace App\Services\Product\Services;

use App\Services\Product\Repositories\ProductRepository;
use App\Services\Product\DTOs\ProductDTO;
use App\Services\Product\Contracts\ProductContract;

class ProductService implements ProductContract
{
    protected $productRepo;

    public function __construct(ProductRepository $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    public function getAll()
    {
        return $this->productRepo->getAll();
    }

    public function getById($id)
    {
        return $this->productRepo->findById($id);
    }

    public function create(ProductDTO $dto)
    {
        return $this->productRepo->create($dto->toArray());
    }

    public function update($id, ProductDTO $dto)
    {
        return $this->productRepo->update($id, $dto->toArray());
    }

    public function delete($id)
    {
        return $this->productRepo->delete($id);
    }
}
