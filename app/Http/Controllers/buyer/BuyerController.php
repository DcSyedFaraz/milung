<?php

namespace App\Http\Controllers\buyer;

use App\Http\Controllers\Controller;
use App\Models\Products;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BuyerController extends Controller
{
    public function product($id)
    {
        // dd($id);
        $product = Products::where('id', $id)->with('product_group')->first();
        return response()->json($product, JsonResponse::HTTP_OK);
    }
}
