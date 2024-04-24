<?php

namespace App\Http\Controllers\buyer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Printview;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Validator;

class BuyerOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $id = Auth::id();
        $id = 2;
        $order = Order::select('id', 'updated_at', 'created_at', 'sendoutdate', 'status', 'group')->where('buyer', $id)->orderby('created_at', 'desc')->get();
        return response()->json($order, JsonResponse::HTTP_OK);
    }

    public function orderentrygetID($id)
    {
        $order = Order::findOrFail($id);
        // dd($order->getRawOriginal('quantity_unit'));
        $order->quantity_units = $order->getRawOriginal('quantity_unit');
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
            'reason' => 'nullable|string',
            'action' => 'required|string',
        ]);
        // dd($request->all(), $id);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }



        $printView = Printview::where('order_id', $id)->first();

        if ($printView) {
            $printView->reason = $request->input('reason') ?? null;
            $printView->action = $request->input('action');
            $printView->save();
        } else {
            $printView = Printview::create([
                'order_id' => $id,
                'reason' => $request->input('reason') ?? null,
                'action' => $request->input('action'),
            ]);
        }


        return response()->json(['message' => 'PrintView saved successfully.'], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // return '$id';
        // dd($request->all(), $id);

        $data = $request->all();
        $existingOrder = Order::findOrFail($id);

        $validatedData = Validator::make($data, [
            'files' => 'required|image',
        ]);

        if ($validatedData->fails()) {
            return response()->json(['errors' => $validatedData->errors()->all()], 422);
        }

        if (isset($data['files']) && $existingOrder->files != $data['files']) {
            $file = $data['files'];
            if ($file) {
                $fileNames = [];
                $fileName = time() . $file->getClientOriginalName();
                $filePath = $file->storeAs('orders/files', $fileName, 'public');
                $fileNames[] = ['filename' => $fileName, 'filepath' => $filePath];
            }
            $data['files'] = $fileNames;
            $order = $existingOrder->update($data);
        }
        return response()->json($order, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
