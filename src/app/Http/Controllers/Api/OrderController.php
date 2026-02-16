<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with(['user', 'product'])->where('user_id', $request->user()->id)->get();
        return response()->json($orders);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // 'user_id' => 'required|integer',
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ]);

        $order = Order::create([
            'user_id' => $request->user()->id, // ← ここが重要
            'product_id' => $validated['product_id'],
            'quantity' => $validated['quantity'],
        ]);

        return response()->json($order, 201);
    }
}
