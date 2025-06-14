<?php

namespace App\Repositories;

use App\Repositories\Interfaces\OrderRepositoryInterface;

use App\Models\Order;

class OrderRepository implements OrderRepositoryInterface
{
    public function create(array $data): Order
    {
        return Order::create($data);
    }

    public function getById(int $id): ?Order
    {
        return Order::with('items.product')->find($id);
    }

    public function getAllByUserId(int $userId)
    {
        return Order::with('items.product')->where('user_id', $userId)->get();
    }
}
