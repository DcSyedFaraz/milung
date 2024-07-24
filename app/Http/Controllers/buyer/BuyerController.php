<?php

namespace App\Http\Controllers\buyer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\PriceInquiry;
use App\Models\Products;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BuyerController extends Controller
{
    public function product($id)
    {
        $product = Products::where('id', $id)->with('printAreas', 'images','product_group')->first();
        // dd($product);
        return response()->json($product, 200);
    }
    public function dashboard()
    {
        // dd($id);
        $data['Buyers'] = User::role('Buyer')->count();
        $data['Supplier'] = User::role('Supplier')->count();
        $data['Product'] = Products::count();
        $data['Order'] = Order::select('id', 'productname', 'sendoutdate', 'status')->latest()->take(3)->get();
        return response()->json($data, 200);
    }
    public function Buyerdashboard()
    {
        // dd($id);
        $id = auth()->user()->buyer_id;
        $data['Inquiry'] = PriceInquiry::where('buyer', $id)->count();
        $data['Products'] = Products::count();
        $data['Orders'] = Order::where('buyer', $id)->count();
        $data['Order'] = Order::select('id', 'productname', 'sendoutdate', 'status')->where('buyer', $id)->latest()->take(3)->get();
        return response()->json($data, 200);
    }
}
