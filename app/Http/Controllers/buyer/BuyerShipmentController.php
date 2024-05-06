<?php

namespace App\Http\Controllers\buyer;

use App\Http\Controllers\Controller;
use App\Models\Information;
use App\Models\Order;
use App\Models\PackingList;
use App\Models\SettleAmount;
use App\Models\Shipment;
use App\Models\ShipmentOrder;
use App\Models\Shipmentbuyer;
use Auth;
use Carbon\Carbon;
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
        $data['order'] = Order::where('buyer', auth()->id())->whereHas('shipmentOrders')->where(function ($query) {
            $query->whereDoesntHave('settleamount')
                ->orWhereHas('settleamount', function ($query) {
                    $query->where('status', '!=', 'full payment');
                });
        })->with('shipmentOrders', 'information')->select('id', 'status', 'sendoutdate', 'so_number', 'totalvalue')->get();

        $data['invoice'] = Information::whereHas('orders', function ($query) {
            $query->where('buyer', auth()->id());
        })->with(['settleamount', 'orders'])->select('id', 'totalpayable', 'invoice', 'created_at', 'shipment_order_id')->get();
        // $data['invoice'] = [];

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
        $data = Order::where('buyer', auth()->id())->where('so_number', $id)->where(function ($query) {
            $query->whereDoesntHave('settleamount')
                ->orWhereHas('settleamount', function ($query) {
                    $query->where('status', '!=', 'full payment');
                });
        })->with('shipmentOrders', 'information')->select('id', 'status', 'sendoutdate', 'so_number', 'totalvalue')->get();
        // dd($data);
        return response()->json($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $rules = [
            'infoIds' => 'required',
            'amount' => 'required|numeric',
            'paymentType' => 'required',
            'file' => 'required|file',
        ];

        // Custom validation callback for validating the amount based on payment type
        $validator = \Validator::make($request->all(), $rules, [
            'amount' => 'Amount validation failed.',
        ])->after(function ($validator) use ($request) {
            $paymentType = $request->input('paymentType');
            $amount = $request->input('amount');
            $infoIds = explode(',', $request->input('infoIds'));

            foreach ($infoIds as $invoiceId) {
                if (!Information::where('id', $invoiceId)->exists()) {
                    $validator->errors()->add('infoIds', 'One or more invoice IDs are invalid.');
                    break;
                }
            }

            if ($paymentType === 'Full Payment') {
                // If Full Payment, validate amount against the sum of totalvalue
                $totalValueSum = Information::whereIn('id', $infoIds)->sum('totalpayable');
                // dd($totalValueSum);
                if ($amount != $totalValueSum) {
                    $validator->errors()->add('amount', 'Amount should be equal to the sum of payable amount of selected invoice/s for Full Payment.');
                }
            } elseif ($paymentType === 'Partial Payment') {
                $totalValueSum = Information::whereIn('id', $infoIds)->sum('totalpayable');
                if ($amount > $totalValueSum) {
                    $validator->errors()->add('amount', 'Amount for Partial Payment should be less than or equal to the sum of payable amount of selected invoice/s.');
                }
            }


        });
        // Check if validation fails
        if ($validator->fails()) {
            // If fails, return back with errors
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $data = $request->all();
        $infoIds = explode(',', $data['infoIds']);
        $amount = $data['amount'];
        $paymentType = $data['paymentType'];
        $shipIds = explode(',', $data['shipIds']);
        $remarks = json_decode($data['remarks'], true);

        $slipFile = null;
        if ($request->hasFile('file')) {
            $slipFile = $request->file('file');
            $fileName = time() . $slipFile->getClientOriginalName();
            $slipPath = $slipFile->storeAs('orders/remittance', $fileName, 'public');
        }

        $remainingAmounts = [];
        foreach ($infoIds as $infoId) {
            $totalpayable = Information::find($infoId)->totalpayable;
            $remainingAmount = max(0, $totalpayable - $amount);
            $remainingAmounts[$infoId] = $remainingAmount;
            $amount = max(0, $amount - ($totalpayable - $remainingAmount));


        }
        // dd($remainingAmounts);

        $combinedIds = array_combine($infoIds, $shipIds);
        // Loop through each combination of order and shipment IDs
        foreach ($combinedIds as $infoId => $shipId) {
            // dd($infoId, $shipId);
            $remark = $remarks[$infoId] ?? null;
            $status = ($remainingAmounts[$infoId] == 0) ? 'Full Payment' : 'Partial Payment';
            $totalpayable = Information::find($infoId)->totalpayable;

            $SettleAmount = SettleAmount::updateOrCreate(
                [
                    'information_id' => $infoId,
                    'shipment_order_id' => $shipId,
                    'user_id' => auth()->id(),
                ],
                [
                    'settle_amount' => $totalpayable,
                    'outstanding_amount' => $remainingAmounts[$infoId],
                    'settle_date' => Carbon::now(),
                    'status' => $status,
                    'remarks' => $remark,

                ]
            );
            if ($slipFile) {
                $SettleAmount->slip = $slipPath;
                $SettleAmount->save();
            }

        }


        return response()->json($SettleAmount, 200);
    }
    public function reject(Request $request)
    {
        // dd($request->all());
        $rules = [
            'infoIds' => 'required',
        ];

        // Custom validation callback for validating the amount based on payment type
        $validator = \Validator::make($request->all(), $rules, [
            'amount' => 'Amount validation failed.',
        ])->after(function ($validator) use ($request) {
            $infoIds = explode(',', $request->input('infoIds'));

            foreach ($infoIds as $invoiceId) {
                if (!Information::where('id', $invoiceId)->exists()) {
                    $validator->errors()->add('infoIds', 'One or more invoice IDs are invalid.');
                    break;
                }
            }

        });
        // Check if validation fails
        if ($validator->fails()) {
            // If fails, return back with errors
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $data = $request->all();
        $infoIds = explode(',', $data['infoIds']);
        $shipIds = explode(',', $data['shipIds']);


        // dd($remainingAmounts);

        $combinedIds = array_combine($infoIds, $shipIds);
        // Loop through each combination of order and shipment IDs
        foreach ($combinedIds as $infoId => $shipId) {
            // dd($infoId, $shipId);

            $totalpayable = Information::find($infoId)->totalpayable;

            $SettleAmount = SettleAmount::updateOrCreate(
                [
                    'information_id' => $infoId,
                    'shipment_order_id' => $shipId,
                    'user_id' => auth()->id(),
                ],
                [
                    'settle_amount' => $totalpayable,
                    'outstanding_amount' => $totalpayable,
                    'status' => 'reject',
                    'settle_date' => null,

                ]
            );

        }


        return response()->json($SettleAmount, 200);
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
