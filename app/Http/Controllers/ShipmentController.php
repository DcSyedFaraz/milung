<?php

namespace App\Http\Controllers;

use App\Models\Information;
use App\Models\Order;
use App\Models\PackingList;
use App\Models\SettleAmount;
use App\Models\Shipment;
use App\Models\ShipmentOrder;
use App\Models\ShipmentSupplier;
use App\Models\SupplierReceipt;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ShipmentController extends Controller
{
    public function information($id)
    {
        $data = Information::where('shipment_order_id', $id)->with('user')->first();
        return response()->json($data, 200);
    }
    public function invoice($id)
    {
        // dd($id);
        $data = ShipmentOrder::where('buyerid', $id)->with('settleamount', 'information', 'shipment')->whereHas('information')->get();
        return response()->json($data, 200);
    }
    public function orders($supplierId, $soId)
    {
        // dd($supplierId, $soId);
        $data['orders'] = Order::where('supplier', $supplierId)->where('so_number', $soId)
            ->with([
                'shipmentOrders',
                'information'
            ])
            ->select('id', 'status', 'sendoutdate', 'so_number', 'totalvalue')
            ->get();
        $data['note'] = SupplierReceipt::where('user_id', $supplierId)->where('shipment_order_id', $soId)->first();
        return response()->json($data, 200);
    }
    public function SupplierSo($id)
    {
        $data['order'] = Order::where('supplier', $id)
            ->with([
                'shipmentOrders' => function ($query) {
                    $query->select('id', 'so_number');
                },
                'information'
            ])
            ->whereNotNull('so_number')
            ->select('id', 'status', 'sendoutdate', 'so_number', 'totalvalue')
            ->get();

        $distinctSoNumbers = $data['order']->pluck('shipmentOrders')
            ->flatten()
            ->unique('so_number')
            ->values()
            ->filter(function ($shipmentOrder) {
                return $shipmentOrder !== null;
            })
            ->map(function ($shipmentOrder) {
                return [
                    'id' => $shipmentOrder->id,
                    'so_number' => $shipmentOrder->so_number,
                ];
            })
            ->filter() // this will remove any null values from the collection
            ->values();

        $data['so'] = $distinctSoNumbers->toArray();

        return response()->json($data, 200);

    }
    public function rcvablesave(Request $request, $id)
    {
        // dd($data);
        // Validate the data
        try {
            $validatedData = $request->validate([
                'settle_amount' => 'nullable|numeric',
                'remarks' => 'required|string',
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
        // Get the totalpayable from the information table based on the $id
        // Fetch information
        $information = Information::where('shipment_order_id', $id)->firstOrFail();
        $totalPayable = $information->totalpayable;

        // Fetch buyer ID
        $buyer = ShipmentOrder::findOrFail($id)->buyerid;

        // Fetch/settle date
        $settle = SettleAmount::where('shipment_order_id', $id)->first();
        $date = $settle ? $settle->settle_date : now();

        // Calculate/settle amount
        $amount = isset($validatedData['settle_amount']) ? $validatedData['settle_amount'] : ($settle ? $settle->settle_amount : null);

        // Calculate outstanding amount
        $outstandingAmount = $totalPayable - $amount;

        // Handle file upload
        $slipPath = null;
        if ($request->hasFile('image')) {
            $slipFile = $request->file('image');
            $fileName = time() . $slipFile->getClientOriginalName();
            $slipPath = $slipFile->storeAs('orders/remittance', $fileName, 'public');
        }

        // Update or create the record in settle_amounts table
        $settleAmount = SettleAmount::updateOrCreate(
            ['information_id' => $information->id, 'shipment_order_id' => $id],
            [
                'settle_amount' => $amount,
                'admin_remarks' => $validatedData['remarks'],
                'settle_date' => $date,
                'admin_slip' => $slipPath,
                'outstanding_amount' => $outstandingAmount,
                'user_id' => $buyer,
            ]
        );

        return response()->json($settleAmount, 200);
    }
    public function create_doc(Request $request)
    {
        $data = $request->all();
        // dd($data);
        $validatedData = \Validator::make($data, [
            'shipment_order_id' => 'required|exists:shipment_orders,id',
            'invoice' => 'required|string',
            'party' => 'required|string',
            'loading' => 'required|string',
            'destination' => 'required|string',
            'payment' => 'required|string',
            'courier' => 'required|string',
            'tracking' => 'required|string',
            'extra' => 'nullable|integer',
            'shipper' => 'required|string',
            'consignee' => 'required|string',
            'carton' => 'required|string',
        ]);

        if ($validatedData->fails()) {
            return response()->json(['errors' => $validatedData->errors()->all()], 422);
        }
        $data['user_id'] = Auth::id();
        // $data['user_id'] = 1;
        unset($data['shipment_order'], $data['user']);
        try {
            // Find or create the Information instance based on the shipment_order_id
            $data['totalpayable'] = Order::where('so_number', $data['shipment_order_id'])->sum('totalvalue') + ($data['extra'] ?? 0);
            Information::updateOrCreate(
                ['shipment_order_id' => $data['shipment_order_id']],
                $data
            );

            return response()->json(['message' => 'Information updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error occurred while updating information' . $e->getMessage()], 500);
        }
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
            // 'supplierid' => 'required|exists:users,id',
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
        return response()->json($shipment, 200);
    }
    public function shipmentgetid($id)
    {
        $packing = PackingList::where('shipment_order_id', $id)->with('orders.product_group', 'supplierid')->get();
        $shipment = ShipmentOrder::findOrFail($id)->select('id', 'buyerid', 'incoterm')->first();
        $data = Shipment::where('shipment_order_id', $id)->where('user_id', $shipment->buyerid)->select('id', 'atc_no')->first();

        $result = compact('packing', 'data', 'shipment');
        // dd($result);
        // $data = [
        //     'shipment' => $shipment,
        //     'totalQty' => $totalQty,
        //     'totalTotalQty' => $totalTotalQty,
        // ];

        return response()->json($result, 200);
    }
    public function shipmentsget()
    {
        $shipment = ShipmentOrder::select('id', 'so_number')->get();
        return response()->json($shipment, 200);
    }
    public function soDelete($id)
    {
        $shipment = ShipmentOrder::findOrFail($id);
        $shipment->delete();

        return response()->json([
            "message" => "Record deleted Successfully",
        ], 200);
        // return response()->json($shipment, 200);
    }
}
