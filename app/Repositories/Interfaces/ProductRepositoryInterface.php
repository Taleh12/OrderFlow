<?php

namespace App\Repositories\Interfaces;

use App\Models\Product;

/**
 * Interface ProductRepositoryInterface
 * @package App\Repositories\Interfaces
 *
 * This interface defines the methods for interacting with Product entities.
 */
interface ProductRepositoryInterface
{
    public function all();
    public function find($id): ?Product;
    public function create(array $data): Product;
    public function update(Product $product, array $data): bool;
    public function delete(Product $product): bool;
}
