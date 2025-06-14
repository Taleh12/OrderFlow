<?php


namespace App\Http\Controllers;

use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    protected OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index()
    {
        $user = Auth::user();

        $orders = $this->orderService->getOrdersByUserId($user->id);

        return response()->json($orders);
    }

    public function show($id)
    {
        $order = $this->orderService->getOrderById($id);

        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        return response()->json($order);
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'total_price' => 'required|numeric|min:0',
        ]);

        $user = Auth::user();

        $order = $this->orderService->createOrder([
            'user_id' => $user->id,
            'items' => $request->items,
            'total_price' => $request->total_price,
            'status' => 'pending',
        ]);

        return response()->json($order, 201);
    }
}
