<?php

namespace App\Http\Controllers;

use App\Models\ShipmentOrder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ShipmentController extends Controller
{
    public function create_so(Request $request)
    {
        $data = $request->all();
        // dd($data);


        $validatedData = \Validator::make($data, [
            'buyerid' => 'required|exists:users,id',
            'method' => 'required|string',
            'port' => 'required|string',
            'destination' => 'required|string',
            'incoterm' => 'required|string',
            'so_number' => 'required|string|unique:shipment_orders',
        ]);

        if ($validatedData->fails()) {
            return response()->json(['errors' => $validatedData->errors()->all()], 422);
        }
        ShipmentOrder::create($data);


        return response()->json(['message' => 'SO# created successfully']);
    }
    public function shipmentget()
    {
        $shipment = ShipmentOrder::with('user')->get();
        return response()->json($shipment, JsonResponse::HTTP_OK);
    }
}
