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
}
