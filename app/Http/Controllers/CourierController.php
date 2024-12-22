<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use Illuminate\Support\Facades\Log;

class CourierController extends Controller
{
    public function courierOrders()
    {
        try { 
            $user = Auth::user();  
            $orders = Order::where('courier_id', $user->id)->with(['service', 'user'])->get(); 
            return response()->json($orders); 
        } catch (\Exception $e) { 
            return response()->json(['message' => 'Error fetching orders', 'error' => $e->getMessage()], 500); 
        }
    }

    public function updateOrderStatus(Request $request, $id)
    {
        try {
            // Validate the incoming request data
            $request->validate([
                'status' => 'required|string|in:pending,confirmed,in_progress,completed,cancelled,ready_for_pickup,out_for_delivery,delivered,on_hold,failed',
                'out_date' => 'nullable|date',
                'return_date' => 'nullable|date',
            ]);

            // Find the order by ID
            $order = Order::find($id);

            if (!$order) {
                return response()->json(['message' => 'Order not found'], 404);
            }

            $order->load(['service', 'user']);
            
            // Update the order status, out_date, and return_date
            $order->status = $request->input('status');
            $order->out_date = $request->input('out_date');
            $order->return_date = $request->input('return_date');
            $order->save();

            Log::info('Request data:', $request->all());
            return response()->json(['message' => 'Order status updated successfully', 'order' => $order], 200);
        } catch (\Exception $e) {
            Log::error('Error updating order: ' . $e->getMessage());
            return response()->json(['message' => 'Error updating order', 'error' => $e->getMessage()], 500);
        }
    }

}
