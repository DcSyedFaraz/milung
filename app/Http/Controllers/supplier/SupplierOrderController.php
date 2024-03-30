<?php

namespace App\Http\Controllers\supplier;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SupplierOrderController extends Controller
{
    public function orderentryget()
    {
        // $id = Auth::id();
        $id = 3;
        $order = Order::select('id', 'updated_at', 'created_at', 'sendoutdate', 'supplier', 'status', 'group')->where('supplier', $id)->orderby('created_at', 'desc')->get();
        return response()->json($order, JsonResponse::HTTP_OK);
    }
}
