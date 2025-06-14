<?php

namespace App\Repositories\Interfaces;

use App\Models\Order;

interface OrderRepositoryInterface
{
    public function create(array $data): Order;

    public function getById(int $id): ?Order;

    public function getAllByUserId(int $userId);
}
