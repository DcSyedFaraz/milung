<?php

namespace App\Http\Controllers\buyer;

use App\Http\Controllers\Controller;
use App\Models\Information;
use App\Models\Order;
use App\Models\PackingList;
use App\Models\Shipment;
use App\Models\ShipmentOrder;
use App\Models\Shipmentbuyer;
use Auth;
use Illuminate\Http\Request;

class BuyerShipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $id = Auth::user()->id;
        $shipment = ShipmentOrder::whereHas('orders', function ($query) use ($id) {
            $query->where('buyer', $id);
        })->with('shipment')->get();
        return response()->json($shipment, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function buyerSos()
    {
        $data['order'] = Order::where('buyer', auth()->id())->whereNotNull('so_number')->with('shipmentOrders', 'information')->select('id', 'status', 'sendoutdate', 'so_number', 'totalvalue')->get();
        $distinctSoNumbers = collect(); // Initialize an empty collection

        $data['order']->each(function ($order) use ($distinctSoNumbers) {
            $order->shipmentOrders->each(function ($shipmentOrder) use ($order, $distinctSoNumbers) {
                // Check if the so_number already exists in the collection
                if (!$distinctSoNumbers->contains('so_number', $shipmentOrder->so_number)) {
                    // If not, add it to the collection
                    $distinctSoNumbers->push([
                        'id' => $shipmentOrder->id,
                        'so_number' => $shipmentOrder->so_number,
                    ]);
                }
            });
        });
        $data['so'] = $distinctSoNumbers->toArray();
        // dd($data);
        return response()->json($data, 200);
    }
    public function buyerSo($id)
    {
        $data = Order::where('buyer', auth()->id())->where('so_number', $id)->with('shipmentOrders', 'information')->select('id', 'status', 'sendoutdate', 'so_number', 'totalvalue')->get();
        // dd($data);
        return response()->json($data, 200);
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
    public function show($id)
    {
        $data = Information::where('shipment_order_id', $id)->with('user')->first();
        return response()->json($data, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $userid = Auth::id();
        $buyer = $request->all();

        $validatedData = \Validator::make($request->all(), [
            'ship_date' => 'required|date',
            'waybill' => 'required|string',
            'ship_agent' => 'required|string',
            'courier' => 'required|string',
            'flight' => 'required|string',
            'vessel' => 'required|string',
            'train' => 'required|string',
            'atc_no' => 'required|string',
            'delivery' => 'required|date',
        ]);


        if ($validatedData->fails()) {
            return response()->json(['errors' => $validatedData->errors()->all()], 422);
        }
        // dd($data);

        Shipment::updateOrCreate(
            ['shipment_order_id' => $id,],
            [
                'user_id' => $userid,
                'ship_date' => $buyer['ship_date'],
                'ship_agent' => $buyer['ship_agent'],
                'waybill' => $buyer['waybill'],
                'courier' => $buyer['courier'],
                'flight' => $buyer['flight'],
                'vessel' => $buyer['vessel'],
                'train' => $buyer['train'],
                'delivery' => $buyer['delivery'],
                'atc_no' => $buyer['atc_no'],
            ]
        );

        return response()->json(['message' => 'Shipment Overview updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
