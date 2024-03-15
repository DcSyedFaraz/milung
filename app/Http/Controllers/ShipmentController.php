<?php

namespace App\Http\Controllers;

use App\Models\PackingList;
use App\Models\Shipment;
use App\Models\ShipmentOrder;
use App\Models\ShipmentSupplier;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ShipmentController extends Controller
{
    public function create_doc(Request $request)
    {
        dd($request->all());
    }
    public function shipment(Request $request, $id)
    {
        // dd($request->all());
        $data = $request->shipment_order;
        $buyer = $request->buyer;
        $supplier = $request->supplier;

        $validatedData = \Validator::make($data, [
            'buyerid' => 'required|exists:users,id',
            'supplierid' => 'required|exists:users,id',
            'method' => 'required|string',
            'remarks' => 'required|string',
            'port' => 'required|string',
            'destination' => 'required|string',
            'incoterm' => 'required|string',
            'so_number' => [
                'required',
                'string',
                Rule::unique('shipment_orders', 'so_number')->ignore($id),
            ],
        ]);
        $ShipmentOrder = ShipmentOrder::findOrFail($id);

        // Check if the incoming so_number is the same as the original value
        if ($data['so_number'] !== $ShipmentOrder->so_number) {
            return response()->json(['error' => 'Cannot change the value of so_number'], 400);
        }

        if ($validatedData->fails()) {
            return response()->json(['errors' => $validatedData->errors()->all()], 422);
        }
        // dd($data);
        $supplierid = $data['supplierid'];
        $buyerid = $data['buyerid'];
        unset($data['buyerid'], $data['supplierid'], $data['user'], $data['shipment'], $data['shipmentsupplier']);
        $ShipmentOrder->update($data);

        Shipment::updateOrCreate(
            ['shipment_order_id' => $ShipmentOrder->id, 'user_id' => $buyerid],
            [
                'ship_date' => $buyer['ship_date'],
                'ship_agent' => $buyer['ship_agent'],
                'waybill' => $buyer['waybill'],
                'courier' => $buyer['courier'],
                'flight' => $buyer['flight'],
                'vessel' => $buyer['vessel'],
                'train' => $buyer['train'],
                'delivery' => $buyer['delivery'],
                'atc_no' => $buyer['atc_no'],
                'remarks' => $buyer['remarks'],
            ]
        );
        ShipmentSupplier::updateOrCreate(
            ['shipment_order_id' => $ShipmentOrder->id, 'user_id' => $supplierid],
            [
                'ship_date' => $supplier['ship_date'],
                'mode_delivery' => $supplier['mode_delivery'],
                'waybill' => $supplier['waybill'],
                'courier' => $supplier['courier'],
                'flight' => $supplier['flight'],
                'vessel' => $supplier['vessel'],
                'train' => $supplier['train'],
                'delivery' => $supplier['delivery'],
                'remarks' => $supplier['remarks'],
            ]
        );

        return response()->json(['message' => 'Shipment Overview updated successfully']);
    }
    public function create_so(Request $request)
    {
        $data = $request->all();
        // dd($data);


        $validatedData = \Validator::make($data, [
            'buyerid' => 'required|exists:users,id',
            'supplierid' => 'required|exists:users,id',
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
        $shipment = ShipmentOrder::with('user', 'shipment', 'shipmentsupplier')->get();
        return response()->json($shipment, JsonResponse::HTTP_OK);
    }
    public function shipmentgetid($id)
    {
        $shipment = PackingList::where('shipment_order_id',$id)->with('orders.product_group','supplierid')->get();
        $totalQty = $shipment->sum('qty');
        $totalTotalQty = $shipment->sum(function($item) {
            // dump($item->totalqty);
            return str_replace(',', '', $item->totalqty); // Remove commas and sum
        });
        // dd($shipment);
        // $data = [
        //     'shipment' => $shipment,
        //     'totalQty' => $totalQty,
        //     'totalTotalQty' => $totalTotalQty,
        // ];

        return response()->json($shipment, JsonResponse::HTTP_OK);
    }
    public function shipmentsget()
    {
        $shipment = ShipmentOrder::select('id', 'so_number')->get();
        return response()->json($shipment, JsonResponse::HTTP_OK);
    }
    public function soDelete($id)
    {
        $shipment = ShipmentOrder::findOrFail($id);
        $shipment->delete();

        return response()->json([
            "message" => "Record deleted Successfully",
        ], JsonResponse::HTTP_OK);
        // return response()->json($shipment, JsonResponse::HTTP_OK);
    }
}
