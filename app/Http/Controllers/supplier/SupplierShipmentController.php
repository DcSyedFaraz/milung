<?php

namespace App\Http\Controllers\supplier;

use App\Http\Controllers\Controller;
use AppMail\PriceInquiryNotification;
use App\Models\Order;
use App\Models\PackingList;
use App\Models\ShipmentOrder;
use App\Models\ShipmentSupplier;
use App\Models\SupplierInvoice;
use App\Models\SupplierProfile;
use App\Models\SupplierReceipt;
use App\Models\User;
use AppNotifications\UserNotification;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Mail;
use Notification;

class SupplierShipmentController extends Controller
{
    public function suppliershipments()
    {
        // $id = 3;
        $id = Auth::user()->id;
        $shipment['ship'] = ShipmentOrder::whereHas('orders', function ($query) use ($id) {
            $query->where('supplier', $id);
        })->select('id', 'so_number')->get();

        $shipment['invoice'] = SupplierInvoice::where('user_id', $id)->with('ordersInvoice')->get();

        return response()->json($shipment, 200);
    }
    public function shipments()
    {
        // $id = 3;
        $id = Auth::user()->id;
        $shipment = ShipmentOrder::whereHas('orders', function ($query) use ($id) {
            $query->where('supplier', $id);
        })->with('shipmentsupplier')->get();
        return response()->json($shipment, 200);
    }
    public function receipt_note(Request $request)
    {
        // dd($request->all());
        $userId = Auth::id();
        // $userId = 3;
        $orders = Order::whereIn('so_number', $request->shipIds)
            ->where('supplier', $userId)->with('product_group', 'packinglist')->select('id', 'so_number', 'supplier', 'group', 'quantity_unit')
            ->get();
        foreach ($orders as $order) {
            $order->userid = Auth::user()->userid;
            // $order->userid = 'Supplier01';
        }
        // dd($orders);
        return response()->json($orders, 200);
    }
    public function shipment(Request $request, $id)
    {
        // dd($request->all());
        // $userid = 3;
        $userid = Auth::id();
        $supplier = $request->all();

        $validatedData = \Validator::make($request->all(), [
            'ship_date' => 'required|date',
            'mode_delivery' => 'required|string',
            'waybill' => 'required|string',
            'courier' => 'required|string',
            'flight' => 'required|string',
            'vessel' => 'required|string',
            'train' => 'required|string',
            'delivery' => 'required|date',
            // 'remarks' => 'required|string',
            // 'shipment_order_id' => 'required|integer|exists:shipment_orders,id'
        ]);


        if ($validatedData->fails()) {
            return response()->json(['errors' => $validatedData->errors()->all()], 422);
        }
        // dd($data);

        ShipmentSupplier::updateOrCreate(
            ['shipment_order_id' => $id, 'user_id' => $userid],
            [
                'ship_date' => $supplier['ship_date'],
                'mode_delivery' => $supplier['mode_delivery'],
                'waybill' => $supplier['waybill'],
                'courier' => $supplier['courier'],
                'flight' => $supplier['flight'],
                'vessel' => $supplier['vessel'],
                'train' => $supplier['train'],
                'delivery' => $supplier['delivery'],
                // 'remarks' => $supplier['remarks'],
            ]
        );

        return response()->json(['message' => 'Shipment Overview updated successfully']);
    }
    public function suppliershipment($id)
    {
        // dd($id);
        $userid = Auth::user()->id;
        // $userid = 3;
        $shipment = Order::where('so_number', $id)->where('supplier', $userid)->select('id', 'so_number', 'supplier', 'group', 'quantity_unit')->with('product_group', 'packinglist')->get();
        return response()->json($shipment, 200);
    }
    public function shipment_details($id)
    {
        // dd($id);
        $userid = Auth::user()->id;
        // $userid = 3;
        $shipment['orders'] = Order::where('so_number', $id)->where('supplier', $userid)->select('id', 'so_number', 'supplier', 'buyingprice', 'quantity_unit', 'status')->with('shipmentSupplier', 'shipmentOrders', 'invoice_number')->get();
        $shipment['note'] = SupplierReceipt::where('shipment_order_id', $id)->where('user_id', $userid)->first();
        return response()->json($shipment, 200);
    }
    public function upload_reciept_note(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'so_number' => 'required|integer|exists:shipment_orders,id',
            'file' => 'required|file|mimes:pdf,jpeg,png|max:2048', // Adjust file types and size as needed
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Get the validated data
        $soNumber = $request->input('so_number');
        $file = $request->file('file');

        // Store the file
        if ($request->hasFile('file')) {
            $slipFile = $request->file('file');
            $fileName = time() . $slipFile->getClientOriginalName();
            $filePath = $slipFile->storeAs('orders/receipt_notes', $fileName, 'public');
        }

        // Save the data to the database
        $receipt = SupplierReceipt::create([
            'shipment_order_id' => $soNumber,
            'user_id' => Auth::id(),
            'receipt_note' => $filePath,
        ]);

        $user = Auth::user();
        $messages = "A supplier ID:$user->userid has uploaded a new receipt note for SO#$soNumber. Please check the details in the system.";

        $admins = User::permission('accountPayable')->role(['Admin', 'Internal'])->get();

        Notification::send($admins, new \App\Notifications\UserNotification($messages, 'Account Payable', 'payable'));

        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new \App\Mail\PriceInquiryNotification($messages, 'Account Payable'));
        }

        return response()->json(['message' => 'The file has been uploaded successfully.'], 201);
    }

    public function invoiceShow($id)
    {
        $invoice['inv'] = SupplierInvoice::where('id', $id)->with('orders', 'orders.product_group', 'user', 'orders.shipmentOrders')->first();
        $invoice['user'] = SupplierProfile::where('user_id', auth()->user()->id)->first();
        return response()->json($invoice, 200);
    }
    public function invoicereminder(Request $request)
    {
        $user = Auth::user();

        $invoiceIds = $request->input('invoice_ids');

        // Retrieve the invoice numbers from the database
        $invoices = SupplierInvoice::whereIn('id', $invoiceIds)->get(['invoice_number']);

        $invoiceNumbers = $invoices->pluck('invoice_number')->toArray();

        $invoiceNumbersList = implode(', ', $invoiceNumbers);
        $message = "Just a quick note to let you know that user '{$user->userid}' named '{$user->name}' has sent payment reminders for the following invoices: {$invoiceNumbersList}.";

        $admins = User::permission('accountPayable')->role(['Admin', 'Internal'])->get();

        Notification::send($admins, new \App\Notifications\UserNotification($message, 'Account Payable-Payment Reminder', null));

        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new \App\Mail\PriceInquiryNotification($message, 'Account Payable-Payment Reminder'));
        }

        return response()->json(['status' => 'success'], 200);
    }
    public function invoice(Request $request)
    {

        try {
            DB::beginTransaction();

            $validator = Validator::make($request->all(), [
                'order_ids' => 'required|array',
                'incoterm' => 'required|string',
                'order_ids.*' => 'exists:orders,id',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $orderIds = $request->input('order_ids');
            $orders = Order::whereIn('id', $orderIds)->get();

            // Check if any of the orders are already part of an invoice
            foreach ($orders as $order) {
                if ($order->invoices()->exists()) {
                    DB::rollBack();
                    return response()->json(['error' => 'One or more orders are already invoiced'], 400);
                }
            }

            // Calculate total value by multiplying value with quantity_unit for each order
            $totalValue = $orders->sum(function ($order) {
                return $order->buyingprice * $order->quantity_unit;
            });

            // Retrieve sh_numbers from orders
            $soNumbers = $orders->pluck('so_number')->unique()->implode(',');

            $invoiceNumber = 'INV' . Carbon::now()->format('Ymd') . str_pad(random_int(0, 999999), 4, '0', STR_PAD_LEFT);

            $invoice = SupplierInvoice::create([
                'invoice_number' => $invoiceNumber,
                'total_value' => $totalValue,
                'shipment_order_id' => $soNumbers,
                'outstanding_amount' => $totalValue,
                'incoterm' => $request->incoterm,
                'user_id' => Auth::id(),
            ]);

            $invoice->orders()->attach($orderIds);

            $user = Auth::user();
            $messages = "An invoice with the number '{$invoiceNumber}' has been successfully created by user: '{$user->userid}' named '{$user->name}'.";

            $admins = User::permission('accountPayable')->role(['Admin', 'Internal'])->get();

            Notification::send($admins, new \App\Notifications\UserNotification($messages, 'Account Payable', 'payable'));

            foreach ($admins as $admin) {
                Mail::to($admin->email)->send(new \App\Mail\PriceInquiryNotification($messages, 'Account Payable'));
            }

            DB::commit();

            return response()->json([
                'message' => 'Invoice created successfully',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            // Log the error or handle it as needed
            return response()->json(['error' => 'An error occurred while creating the invoice'], 500);
        }
    }
    public function suppliershipmentUpdate($id, Request $request)
    {

        // $userId = 3;
        $userId = Auth::user()->id;

        try {
            \DB::beginTransaction();

            $data = $request->packinglist;

            $validatedData = \Validator::make($data, [
                'carton' => 'required|string',
                'qty' => 'required|integer',
                'nw' => 'required|numeric',
                'gw' => 'required|numeric',
                'lcm' => 'required|numeric',
                'wcm' => 'required|numeric',
                'hcm' => 'required|numeric',
            ]);

            if ($validatedData->fails()) {
                return response()->json(['errors' => $validatedData->errors()->all()], 422);
            }

            // Convert dimensions from centimeters to meters
            $lcmInMeters = $data['lcm'] / 100;
            $wcmInMeters = $data['wcm'] / 100;
            $hcmInMeters = $data['hcm'] / 100;

            // Calculate the volume in cubic meters
            $totalVolume = $lcmInMeters * $wcmInMeters * $hcmInMeters;
            $quantityUnit = intval($request->quantity_unit);
            // dd($quantityUnit);

            $PackingList = PackingList::updateOrCreate(
                ['order_id' => $id, 'shipment_order_id' => $request->so_number],
                [
                    'user_id' => $userId,
                    'carton' => $data['carton'],
                    'qty' => $data['qty'],
                    'totalqty' => $data['qty'] * $quantityUnit,
                    'nw' => $data['nw'],
                    'totalnw' => $data['nw'] * $data['qty'],
                    'gw' => $data['gw'],
                    'totalgw' => $data['gw'] * $data['qty'],
                    'lcm' => $data['lcm'],
                    'wcm' => $data['wcm'],
                    'hcm' => $data['hcm'],
                    'totalVolume' => $totalVolume,
                ]
            );

            \DB::commit();

            return response()->json([
                'message' => 'Shipment updated successfully',
                'data' => $PackingList,
            ]);

        } catch (\Exception $e) {
            \DB::rollBack();
            // Log the error or handle it as needed
            \Log::error('Error while updating shipment: ' . $e->getMessage());

            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function infosave($id, Request $request)
    {

        // dd($request->all());
        // $userId = 8;

        if (Auth::user()->hasRole('admin')) {
            $userId = $request->input('user_id');
        } else {
            $userId = Auth::user()->id;
        }

        try {
            \DB::beginTransaction();

            $data = $request->all();

            $validatedData = \Validator::make($data, [
                'carton' => 'required|string',
                'qty' => 'required|integer',
                'nw' => 'required|numeric',
                'gw' => 'required|numeric',
                'lcm' => 'required|numeric',
                'wcm' => 'required|numeric',
                'hcm' => 'required|numeric',
            ]);

            if ($validatedData->fails()) {
                return response()->json(['errors' => $validatedData->errors()->all()], 422);
            }

            // Convert dimensions from centimeters to meters
            $lcmInMeters = $data['lcm'] / 100;
            $wcmInMeters = $data['wcm'] / 100;
            $hcmInMeters = $data['hcm'] / 100;

            // Calculate the volume in cubic meters
            $totalVolume = $lcmInMeters * $wcmInMeters * $hcmInMeters;
            $quantityUnit = intval($request->orders['quantity_unit']);

            $PackingList = PackingList::updateOrCreate(
                ['user_id' => $userId, 'order_id' => $request->order_id, 'shipment_order_id' => $request->shipment_order_id],
                [
                    'carton' => $data['carton'],
                    'qty' => $data['qty'],
                    'totalqty' => $data['qty'] * $quantityUnit,
                    'nw' => $data['nw'],
                    'totalnw' => $data['nw'] * $data['qty'],
                    'gw' => $data['gw'],
                    'totalgw' => $data['gw'] * $data['qty'],
                    'lcm' => $data['lcm'],
                    'wcm' => $data['wcm'],
                    'hcm' => $data['hcm'],
                    'totalVolume' => $totalVolume,
                ]
            );

            \DB::commit();

            return response()->json([
                'message' => 'Shipment updated successfully',
                'data' => $PackingList,
            ]);

        } catch (\Exception $e) {
            \DB::rollBack();
            // Log the error or handle it as needed
            \Log::error('Error while updating shipment: ' . $e->getMessage());

            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
