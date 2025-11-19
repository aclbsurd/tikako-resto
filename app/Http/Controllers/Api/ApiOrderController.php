<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order; 

class ApiOrderController extends Controller
{
    public function latestOrders(Request $request)
    {
        $latestOrder = Order::orderBy('id', 'desc')->first();
        $totalNewOrders = Order::where('status', 'Diterima')->count();        
        return response()->json([
            'latest_order' => $latestOrder,
            'new_count' => $totalNewOrders,
            'status' => 'success'
        ]);
    }
}