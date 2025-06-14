<?php

namespace App\Services;

use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class OrderService
{
    protected OrderRepositoryInterface $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * Yeni sifariş yaratmaq
     * $data nümunəsi:
     * [
     *   'user_id' => 1,
     *   'status' => 'pending',
     *   'total_price' => 123.45,
     *   'items' => [
     *       ['product_id' => 1, 'quantity' => 2, 'price' => 50],
     *       ['product_id' => 2, 'quantity' => 1, 'price' => 23.45],
     *    ]
     * ]
     */
    public function createOrder(array $data)
    {
        return DB::transaction(function () use ($data) {
            $orderData = [
                'user_id' => $data['user_id'],
                'status' => $data['status'] ?? 'pending',
                'total_price' => $data['total_price'],
            ];

            $order = $this->orderRepository->create($orderData);

            foreach ($data['items'] as $item) {
                $order->items()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }

            return $order->load('items.product');
        });
    }

    public function getOrderById(int $id)
    {
        return $this->orderRepository->getById($id);
    }

    public function getOrdersByUserId(int $userId)
    {
        return $this->orderRepository->getAllByUserId($userId);
    }
}
