<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index()
    {
        try {
            $orders = Order::all();
            return response()->json($orders);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error fetching orders', 'error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'service_id' => 'required|exists:services,id',
                'baskets' => 'required|integer|min:1',
                'address' => 'required|string|max:255',
                'postal_code' => 'required|string|max:10',
                'notes' => 'nullable|string',
                'payment_mode' => 'required|in:cash,credit_card,paypal',
            ]);

            $service = Service::findOrFail($request->service_id);
            $totalPrice = $service->price * $request->baskets;

            // Get authenticated user's ID 
            $userId = Auth::id(); 
            Log::info('Authenticated user ID:', ['user_id' => $userId]);

            $validated['total_price'] = $totalPrice;
            $validated['user_id'] = $userId;

            $order = Order::create($validated);
            return response()->json(['message' => 'Order created successfully', 'order' => $order], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error: ' . $e->getMessage());
            return response()->json(['message' => 'Validation error', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Error creating order: ' . $e->getMessage());
            return response()->json(['message' => 'Error creating order', 'error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $order = Order::findOrFail($id);
            return response()->json([
                'order_id' => $order->id,
                'service_id' => $order->service_id,
                'baskets' => $order->baskets,
                'address' => $order->address,
                'postal_code' => $order->postal_code,
                'notes' => $order->notes,
                'payment_mode' => $order->payment_mode,
                'total_price' => $order->total_price,
                'order_date' => $order->created_at->format('Y-m-d H:i:s'),
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error fetching order', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'service_id' => 'exists:services,id',
                'baskets' => 'integer|min:1',
                'address' => 'string|max:255',
                'payment_mode' => 'in:cash,credit_card,paypal',
            ]);

            $order = Order::findOrFail($id);
            $order->update($validated);
            return response()->json(['message' => 'Order updated successfully', 'order' => $order], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error updating order', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $order = Order::findOrFail($id);
            $order->delete();
            return response()->json(['message' => 'Order deleted successfully'], 204);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting order', 'error' => $e->getMessage()], 500);
        }
    }
}
