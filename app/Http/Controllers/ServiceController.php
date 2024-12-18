<?php

namespace App\Http\Controllers;

use App\Models\Service; 
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        try {
            $services = Service::all();
            return response()->json($services);
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Error fetching services:', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Error fetching services'], 500);
        }
    }

    public function update(Request $request, $id) 
    { 
        $service = Service::find($id); 
        if (!$service) { 
            return response()->json(['message' => 'Service not found'], 404); 
        } 
        
        $service->name = $request->input('name'); 
        $service->description = $request->input('description'); 
        $service->price = $request->input('price'); 
        $service->save(); 
        
        return response()->json($service); 
    }

    public function store(Request $request) 
    { 
        $request->validate([ 
            'name' => 'required|string|max:255', 
            'description' => 'required|string', 
            'price' => 'required|numeric', 
        ]); 
        
        $service = new Service(); 
        $service->name = $request->input('name'); 
        $service->description = $request->input('description'); 
        $service->price = $request->input('price'); 
        $service->save(); return response()->json($service, 201); 
    }
}
