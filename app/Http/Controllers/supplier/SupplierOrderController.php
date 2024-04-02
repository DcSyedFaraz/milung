<?php

namespace App\Http\Controllers\supplier;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Printview;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Validator;

class SupplierOrderController extends Controller
{
    public function orderentryget()
    {
        // $id = Auth::id();
        $id = 3;
        $order = Order::select('id', 'updated_at', 'created_at', 'sendoutdate', 'supplier', 'status', 'group')->where('supplier', $id)->orderby('created_at', 'desc')->get();
        return response()->json($order, JsonResponse::HTTP_OK);
    }
    public function orderentrygetID($id)
    {
        $order = Order::where('id', $id)->with('product_group', 'shipmentOrders', 'printview')->first();
        // dd($order);
        return response()->json($order, JsonResponse::HTTP_OK);
    }
    public function printviewget($id)
    {
        $printview = Printview::where('order_id', $id)->first();
        return $printview;
    }
    public function printview(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'product' => 'nullable|image',
            'packaging' => 'nullable|image',
            'accessories' => 'nullable|image',
            'reason' => 'nullable|string',
        ]);
        // dd($request->all(), $id);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }



        $printView = Printview::where('order_id', $id)->first();

        if ($printView) {
            $printView->reason = $request->input('reason');

            if ($request->hasFile('product')) {
                $printView->product = $request->file('product')->store('orders/images', 'public');
            }

            if ($request->hasFile('packaging')) {
                $printView->packaging = $request->file('packaging')->store('orders/images', 'public');
            }

            if ($request->hasFile('accessories')) {
                $printView->accessories = $request->file('accessories')->store('orders/images', 'public');
            }

            $printView->save();
        } else {
            if (!$request->hasFile('product') && !$request->hasFile('packaging') && !$request->hasFile('accessories')) {
                return response()->json(['errors' => 'At least one file must be uploaded.'], 422);
            }
            $printView = Printview::create([
                'order_id' => $id,
                'reason' => $request->input('reason'),
                'product' => $request->hasFile('product') ? $request->file('product')->store('orders/images', 'public') : null,
                'packaging' => $request->hasFile('packaging') ? $request->file('packaging')->store('orders/images', 'public') : null,
                'accessories' => $request->hasFile('accessories') ? $request->file('accessories')->store('orders/images', 'public') : null,
            ]);
        }


        return response()->json(['message' => 'PrintView saved successfully.'], 200);
    }
    public function masscargo(Request $request, $id)
    {
        dd($request->all(), $id);
    }
}
