<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Product;

class OrderController extends Controller
{
    public function index()
    {
        try { 
            $user = Auth::user();  
            $orders = Order::where('user_id', $user->id)->with(['service', 'product', 'user'])->get(); 
            return response()->json($orders); 
        } catch (\Exception $e) { 
            return response()->json(['message' => 'Error fetching orders', 'error' => $e->getMessage()], 500); 
        }
    }

    public function showAll()
    {
        try{
            $orders = Order::with(['service', 'user'])->get();
            return response()->json($orders);
        } catch (\Exception $e) {
            \Log::error('Error fetching orders:', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Error fetching orders'], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'service_id' => 'required|exists:services,id',
                'product_id' => 'required|exists:products,id',
                'baskets' => 'required|integer|min:1',
                'address' => 'required|string|max:255',
                'postal_code' => 'required|string|max:10',
                'notes' => 'nullable|string',
                'payment_mode' => 'required|in:cash,credit_card,paypal',
            ]);

            $service = Service::findOrFail($request->service_id);
            $product = Product::findOrFail($request->product_id);
            $totalPrice = $product->price * $request->baskets + ($service->price * $request->baskets);

            // Get authenticated user's ID 
            $userId = Auth::id(); 
            Log::info('Authenticated user ID:', ['user_id' => $userId]);

            $validated['total_price'] = $totalPrice;
            $validated['user_id'] = $userId;
            $validated['status'] = 'pending';

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
                'status' => 'in:pending,confirmed,in_progress,ready_for_pickup,out_for_delivery,delivered,completed,cancelled,on_hold,failed',
            ]);

            $order = Order::findOrFail($id);
            $order->update($validated);
            return response()->json(['message' => 'Order updated successfully', 'order' => $order], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error updating order', 'error' => $e->getMessage()], 500);
        }
    }
    
    public function updateStatus(Request $request, $id)
    {
        $order = Order::find($id);

        if (!$order) { 
            return response()->json(['message' => 'Order not found'], 404); 
        } 
        
        $order->status = $request->input('status'); 
        $order->save(); 
        
        return response()->json(['message' => 'Order status updated successfully', 'order' => $order], 200);
    }

    public function destroy($id)
    {
        try {
            $order = Order::findOrFail($id);

            if ($order->status !== 'cancelled' && $order->status !== 'completed') { 
                return response()->json(['message' => 'Only cancelled and completed orders can be deleted'], 403); 
            }

            $order->delete();

            return response()->json(['message' => 'Order deleted successfully'], 200);
        } catch (\Exception $e) {
            Log::error('Error deleting order: ' . $e->getMessage());
            return response()->json(['message' => 'Error deleting order', 'error' => $e->getMessage()], 500);
        }
    }

    public function cancel($id)
    {
        try {
            $order = Order::findOrFail($id);

            if ($order->status !== 'pending') {
                return response()->json(['message' => 'Only pending orders can be canceled'], 403);
            }

            $order->status = 'cancelled';
            $order->save();

            return response()->json(['message' => 'Order cancelled successfully', 'order' => $order], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error cancelling order', 'error' => $e->getMessage()], 500);
        }
    }

    public function assignCourier(Request $request, $id)
    {
        // Validate the incoming request data
        $request->validate([
            'courier_id' => 'nullable|exists:users,id'
        ]);

        // Find the order by ID
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Assign the courier to the order if `courier_id` is provided
        if ($request->has('courier_id')) {
            Log::info('Assigning courier:', ['courier_id' => $request->input('courier_id')]);
            $order->courier_id = $request->input('courier_id');
        }

        $order->save();

        return response()->json(['message' => 'Order updated successfully', 'order' => $order], 200);
    }


}
