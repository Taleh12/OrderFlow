<?php


namespace App\Http\Controllers;

use App\Events\OrderCreated;
use App\Models\Order;
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
        $order = Order::create($request->all());

        // Event atılır
        event(new OrderCreated($order));

        return response()->json(['order' => $order], 201);
    }
}
