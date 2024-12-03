<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Order::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([ 
            'service' => 'required|string', 
            'baskets' => 'required|integer', 
            'address' => 'required|string', 
            'payment_mode' => 'required|string', 
            'amount' => 'required|numeric',
        ]);

        $order = Order::create($request->all());
        return response()->json($order, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return Order::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([ 
            'service' => 'string', 
            'baskets' => 'integer', 
            'address' => 'string', 
            'payment_mode' => 'string', 
            'amount' => 'numeric', 
        ]);

        $order = Order::findOrFail($id); 
        $order->update($request->all()); 
        return response()->json($order, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Order::findOrFail($id)->delete(); 
        return response()->json(null, 204);
    }
}
