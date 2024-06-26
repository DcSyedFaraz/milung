<?php

namespace App\Http\Controllers\supplier;

use App\Http\Controllers\Controller;
use App\Models\MassCargo;
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
        $id = Auth::id();
        // $id = 3;
        $order = Order::select('id', 'updated_at', 'created_at', 'sendoutdate', 'supplier', 'status', 'group')->where('supplier', $id)->orderby('created_at', 'desc')->get();
        return response()->json($order, 200);
    }
    public function orderentrygetID($id)
    {
        $order = Order::where('id', $id)->with('product_group', 'shipmentOrders', 'printview')->first();
        // dd($order);
        return response()->json($order, 200);
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
        $validator = Validator::make($request->all(), [
            'cargo_product' => 'nullable|image',
            'cargo_packaging' => 'nullable|image',
            'cargo_accessories' => 'nullable|image',
            'cargo_reason' => 'nullable|string',
        ]);
        // dd($request->all(), $id);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }



        $MassCargo = MassCargo::where('order_id', $id)->first();

        if ($MassCargo) {
            $MassCargo->reason = $request->input('cargo_reason');

            if ($request->hasFile('cargo_product')) {
                $MassCargo->product = $request->file('cargo_product')->store('orders/images', 'public');
            }

            if ($request->hasFile('cargo_packaging')) {
                $MassCargo->packaging = $request->file('cargo_packaging')->store('orders/images', 'public');
            }

            if ($request->hasFile('cargo_accessories')) {
                $MassCargo->accessories = $request->file('cargo_accessories')->store('orders/images', 'public');
            }

            $MassCargo->save();
        } else {
            if (!$request->hasFile('cargo_product') && !$request->hasFile('cargo_packaging') && !$request->hasFile('cargo_accessories')) {
                return response()->json(['errors' => 'At least one file must be uploaded.'], 422);
            }
            $MassCargo = MassCargo::create([
                'order_id' => $id,
                'cargo_reason' => $request->input('cargo_reason'),
                'cargo_product' => $request->hasFile('cargo_product') ? $request->file('cargo_product')->store('orders/images', 'public') : null,
                'cargo_packaging' => $request->hasFile('cargo_packaging') ? $request->file('cargo_packaging')->store('orders/images', 'public') : null,
                'cargo_accessories' => $request->hasFile('cargo_accessories') ? $request->file('cargo_accessories')->store('orders/images', 'public') : null,
            ]);
        }


        return response()->json(['message' => 'MassCargo saved successfully.'], 200);
    }
}
