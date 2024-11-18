<?php

namespace App\Http\Controllers;

use App\Mail\PriceInquiryNotification;
use App\Models\BuyerProfile;
use App\Models\Information;
use App\Models\Order;
use App\Models\PackingList;
use App\Models\SettleAmount;
use App\Models\Shipment;
use App\Models\ShipmentOrder;
use App\Models\ShipmentSupplier;
use App\Models\SupplierInvoice;
use App\Models\SupplierProfile;
use App\Models\SupplierReceipt;
use App\Models\User;
use App\Notifications\UserNotification;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Notification;

class ShipmentController extends Controller
{
    public function payment(Request $request)
    {
        // dd($request->all());
        $rules = [
            'invIds' => 'required',
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
            $invIds = explode(',', $request->input('invIds'));

            foreach ($invIds as $invoiceId) {
                if (!SupplierInvoice::where('id', $invoiceId)->exists()) {
                    $validator->errors()->add('invIds', 'One or more invoice IDs are invalid.');
                    break;
                }
            }

            if ($paymentType === 'Full Payment') {
                // If Full Payment, validate amount against the sum of totalvalue
                $totalValueSum = SupplierInvoice::whereIn('id', $invIds)->sum('outstanding_amount');
                // dd($totalValueSum);
                if ($amount != $totalValueSum) {
                    $validator->errors()->add('amount', 'Amount should be equal to the sum of outstanding amount of selected invoice/s for Full Payment.');
                }
            } elseif ($paymentType === 'Partial Payment') {
                $totalValueSum = SupplierInvoice::whereIn('id', $invIds)->sum('outstanding_amount');
                if ($amount > $totalValueSum) {
                    $validator->errors()->add('amount', 'Amount for Partial Payment should be less than or equal to the sum of outstanding amount of selected invoice/s.');
                }
            }


        });
        // Check if validation fails
        if ($validator->fails()) {
            // If fails, return back with errors
            return response()->json(['errors' => $validator->errors()], 422);
        }
        try {
            \DB::beginTransaction();

            $data = $request->all();
            $invIds = explode(',', $data['invIds']);
            $amount = $data['amount'];

            $remarks = json_decode($data['remarks'], true);

            $slipFile = null;
            if ($request->hasFile('file')) {
                $slipFile = $request->file('file');
                $fileName = time() . $slipFile->getClientOriginalName();
                $slipPath = $slipFile->storeAs('orders/remittance', $fileName, 'public');
            }

            $remainingAmounts = [];
            $supplierId = null;
            $invoiceNumbers = [];

            foreach ($invIds as $infoId) {

                $invoice = SupplierInvoice::find($infoId);
                if (!$supplierId) {
                    $supplierId = $invoice->user_id;
                }

                $outstanding_amount = $invoice->outstanding_amount;
                $remainingAmount = max(0, $outstanding_amount - $amount);
                $remainingAmounts[$infoId] = $remainingAmount;
                $amount = max(0, $amount - ($outstanding_amount - $remainingAmount));
                $invoiceNumbers[] = $invoice->invoice_number;

                // dd($remainingAmount);
            }
            // dd($remainingAmounts);

            // Loop through each combination of order and shipment IDs
            foreach ($remainingAmounts as $infoId => $shipId) {
                // dd($infoId, $shipId);
                $remark = $remarks[$infoId] ?? null;
                $status = ($remainingAmounts[$infoId] == 0) ? 'Full Payment' : 'Partial Payment';
                $SupplierInvoice = SupplierInvoice::find($infoId);

                $SupplierInvoice->update([
                    'settle_amount' => $SupplierInvoice->total_value - $remainingAmounts[$infoId],
                    'outstanding_amount' => $remainingAmounts[$infoId],
                    'settle_date' => Carbon::now(),
                    'status' => $status,
                    'remarks' => $remark,
                ]);

                if ($slipFile) {
                    $invoice->update(['slip' => $slipPath]);
                }
            }

            $invoiceList = implode(', ', $invoiceNumbers);
            $message = "Payment has been received for the following invoice(s): $invoiceList. Please review and confirm the receipt.";
            $supplier = User::where('supplier_id', $supplierId)->get();

            $route = 'supplier_recievables';
            // Send the notification to the supplier
            Notification::send($supplier, new UserNotification($message, 'Account Receivable - Payment Received', $route));

            // Send the email to the supplier
            foreach ($supplierId as $key => $user) {
                Mail::to($user->email)->send(new PriceInquiryNotification($message, 'Account Receivable - Payment Received'));
            }
            \DB::commit();
            return response()->json($SupplierInvoice, 200);
        } catch (\Exception $e) {
            \DB::rollBack();
            // throw $e;
            // Return error response if an exception occurs
            return response()->json(['message' => 'Failed to save data', 'error' => $e->getMessage()], 500);
        }
    }
    public function information($id)
    {
        $data = Information::where('shipment_order_id', $id)->with('user')->first();
        if (!$data) {
            // In the controller
            $shipmentOrder = ShipmentOrder::with('user')->find($id);
            if ($shipmentOrder && $shipmentOrder->user) {
                $data = [
                    'consignee' => $shipmentOrder->user->consignee,
                ];
            }

        }
        return response()->json($data, 200);
    }
    public function supplier_invoice($id)
    {
        $query = SupplierInvoice::query()
            ->where('id', $id)
            ->with([
                'orders' => function ($query) {
                    $query->with(['product_group', 'shipmentOrders']);
                },
                'user'
            ]);

        $invoice = $query->first();

        if (!$invoice) {
            abort(404, 'Supplier invoice not found.');
        }

        $user = SupplierProfile::where('id', $invoice->user_id)->first();

        return response()->json([
            'inv' => $invoice,
            'user' => $user
        ], 200);
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
                'invoice_number'
            ])
            ->select('id', 'status', 'sendoutdate', 'so_number', 'totalvalue', 'buyingprice', 'quantity_unit')
            ->get();
        $data['note'] = SupplierReceipt::where('user_id', $supplierId)->where('shipment_order_id', $soId)->first();
        $data['invoice'] = SupplierInvoice::where('user_id', $supplierId)->where('shipment_order_id', $soId)->with('ordersInvoice')->get();
        return response()->json($data, 200);
    }
    public function SupplierSo($id)
    {
        $data['order'] = Order::where('supplier', $id)
            ->with([
                'shipmentOrders' => function ($query) {
                    $query->select('id', 'so_number');
                },
                'invoice_number'
            ])
            ->whereHas('shipmentOrders')
            ->select('id', 'status', 'sendoutdate', 'so_number', 'totalvalue', 'buyingprice', 'quantity_unit')
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
        $valid = $request->all();
        $data = $request->shipment_order;
        $buyer = $request->buyer;
        $supplier = $request->supplier;

        $validatedData = \Validator::make($valid, [
            // 'supplierid' => 'required|exists:users,id',
            'shipment_order.id' => 'required|integer',
            'shipment_order.so_number' => "required|string|max:255|unique:shipment_orders,so_number,$id",
            'shipment_order.buyerid' => 'required|integer|exists:buyer_profiles,id',
            'shipment_order.method' => 'required|string|max:255',
            'shipment_order.port' => 'required|string|max:255',
            'shipment_order.remarks' => 'nullable|string|max:255',
            'shipment_order.destination' => 'required|string|max:255',
            'shipment_order.incoterm' => 'required|string|max:255',
            'shipment_order.created_at' => 'required|date',
            'shipment_order.updated_at' => 'required|date',
            'shipment_order.supplier_ids.*.id' => 'required|integer',
            'shipment_order.supplier_ids.*.supplier_id' => 'required|string|max:255',
            'shipment_order.user.id' => 'required|integer',
            'shipment_order.user.buyer_id' => 'required|string|max:255',
            'shipment_order.shipmentsupplier.*.id' => 'required|integer',
            'shipment_order.shipmentsupplier.*.ship_date' => 'required|date',
            'shipment_order.shipmentsupplier.*.mode_delivery' => 'required|string|max:255',
            'shipment_order.shipmentsupplier.*.waybill' => 'nullable|string|max:255',
            'shipment_order.shipmentsupplier.*.courier' => 'nullable|string|max:255',
            'shipment_order.shipmentsupplier.*.flight' => 'nullable|string|max:255',
            'shipment_order.shipmentsupplier.*.vessel' => 'nullable|string|max:255',
            'shipment_order.shipmentsupplier.*.train' => 'nullable|string|max:255',
            'shipment_order.shipmentsupplier.*.delivery' => 'required|date',
            'shipment_order.shipmentsupplier.*.remarks' => 'nullable|string|max:255',
            'shipment_order.shipmentsupplier.*.user_id' => 'required|integer',
            'shipment_order.shipmentsupplier.*.shipment_order_id' => 'required|integer',
            'buyer.ship_date' => 'required|date',
            'buyer.ship_agent' => 'nullable|string|max:255',
            'buyer.waybill' => 'nullable|string|max:255',
            'buyer.courier' => 'nullable|string|max:255',
            'buyer.flight' => 'nullable|string|max:255',
            'buyer.vessel' => 'nullable|string|max:255',
            'buyer.train' => 'nullable|string|max:255',
            'buyer.delivery' => 'required|date',
            'buyer.atc_no' => 'nullable|string|max:255',
            'buyer.remarks' => 'nullable|string|max:255',
            'supplier.*.ship_date' => 'required|date',
            'supplier.*.mode_delivery' => 'required|string|max:255',
            'supplier.*.waybill' => 'nullable|string|max:255',
            'supplier.*.courier' => 'nullable|string|max:255',
            'supplier.*.flight' => 'nullable|string|max:255',
            'supplier.*.vessel' => 'nullable|string|max:255',
            'supplier.*.train' => 'nullable|string|max:255',
            'supplier.*.delivery' => 'required|date',
            'supplier.*.remarks' => 'nullable|string|max:255',
            'supplier.*.user_id' => 'required|integer',
        ]);
        $ShipmentOrder = ShipmentOrder::findOrFail($id);

        // Check if the incoming so_number is the same as the original value
        if ($data['so_number'] !== $ShipmentOrder->so_number) {
            return response()->json(['error' => 'Cannot change the value of so_number'], 400);
        }

        if ($validatedData->fails()) {
            return response()->json(['errors' => $validatedData->errors()->all()], 422);
        }
        // dd($supplier);
        // $supplierid = $data['supplierid'];
        $buyerid = $data['buyerid'];
        unset($data['buyerid'], $data['supplierid'], $data['user'], $data['shipment'], $data['shipmentsupplier'], $data['supplier_ids']);
        $ShipmentOrder->update($data);

        Shipment::updateOrCreate(
            ['shipment_order_id' => $ShipmentOrder->id, 'user_id' => $buyerid],
            array_filter([
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
            ], function ($value) {
                return !is_null($value);
            })
        );
        if ($supplier) {
            foreach ($supplier as $supplierShipment) {
                ShipmentSupplier::updateOrCreate(
                    ['shipment_order_id' => $ShipmentOrder->id, 'user_id' => $supplierShipment['user_id']],
                    array_filter([
                        'ship_date' => $supplierShipment['ship_date'],
                        'mode_delivery' => $supplierShipment['mode_delivery'],
                        'waybill' => $supplierShipment['waybill'],
                        'courier' => $supplierShipment['courier'],
                        'flight' => $supplierShipment['flight'],
                        'vessel' => $supplierShipment['vessel'],
                        'train' => $supplierShipment['train'],
                        'delivery' => $supplierShipment['delivery'],
                        'remarks' => $supplierShipment['remarks'],
                    ], function ($value) {
                        return !is_null($value);
                    })
                );
            }
        }
        $this->logEvent('SO', "SO# {$ShipmentOrder->id} has been updated.");
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
        $so = ShipmentOrder::create($data);
        $this->logEvent('SO', "SO# {$so->id} has been created.");

        return response()->json(['message' => 'SO# created successfully']);
    }
    public function shipmentget()
    {
        $shipments = ShipmentOrder::with('user', 'shipment', 'shipmentsupplier')->get();

        $shipments->each(function ($shipment) {
            $orders = Order::where('so_number', $shipment->id)
                ->whereHas('supplierid')
                ->with('supplierid:id,supplier_id')
                ->get();

            $shipment->supplier_ids = $orders->map(function ($order) {
                return $order->supplierid;
            })->unique()->values();
        });

        return response()->json($shipments, 200);
    }
    public function invoicereminder(Request $request)
    {
        $user = Auth::user();

        $invoiceIds = $request->input('invoice_ids');
        $buyer = $request->input('buyerid');
        // Retrieve the invoice numbers from the database


        $invoiceNumbersList = implode(', ', $invoiceIds);
        $message = "Just a quick note to let you know that user '{$user->userid}' named '{$user->name}' has sent payment reminders for the following invoices: {$invoiceNumbersList}.";

        $buyers = User::find($buyer);

        Notification::send($buyers, new UserNotification($message, 'Account Payable-Payment Reminder', null));

        Mail::to($buyers->email)->send(mailable: new PriceInquiryNotification($message, 'Account Payable-Payment Reminder'));


        return response()->json(['status' => 'success'], 200);
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
        $this->logEvent('SO', "SO# {$shipment->id} has been deleted.");

        return response()->json([
            "message" => "Record deleted Successfully",
        ], 200);
        // return response()->json($shipment, 200);
    }
}
