<?php

namespace App\Services;

use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Models\Product;

class ProductService
{
    public function __construct(protected ProductRepositoryInterface $productRepo) {}

    public function list()
    {
        return $this->productRepo->all();
    }

    public function create(array $data)
    {
        return $this->productRepo->create($data);
    }

    public function update(Product $product, array $data)
    {
        return $this->productRepo->update($product, $data);
    }

    public function delete(Product $product)
    {
        return $this->productRepo->delete($product);
    }
}
