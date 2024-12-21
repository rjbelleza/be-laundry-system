<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    // Display a listing of the deliveries
    public function index()
    {
        $deliveries = Delivery::all();
        return response()->json($deliveries);
    }

    // Show the form for creating a new delivery
    public function create()
    {
        // Return a view for creating a new delivery (if using views)
    }

    // Store a newly created delivery in storage
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'courier_id' => 'required|exists:users,id',
            'outDate' => 'required|date',
            'returnDate' => 'nullable|date',
            'cost' => 'required|numeric',
        ]);

        $delivery = Delivery::create($request->all());
        return response()->json($delivery, 201);
    }

    // Display the specified delivery
    public function show($id)
    {
        $delivery = Delivery::findOrFail($id);
        return response()->json($delivery);
    }

    // Show the form for editing the specified delivery
    public function edit($id)
    {
        // Return a view for editing the delivery (if using views)
    }

    // Update the specified delivery in storage
    public function update(Request $request, $id)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'courier_id' => 'required|exists:users,id',
            'outDate' => 'required|date',
            'returnDate' => 'nullable|date',
            'cost' => 'required|numeric',
        ]);

        $delivery = Delivery::findOrFail($id);
        $delivery->update($request->all());
        return response()->json($delivery);
    }

    // Remove the specified delivery from storage
    public function destroy($id)
    {
        $delivery = Delivery::findOrFail($id);
        $delivery->delete();
        return response()->json(null, 204);
    }
}
