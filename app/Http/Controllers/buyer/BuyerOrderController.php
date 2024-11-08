<?php

namespace App\Http\Controllers\buyer;

use App\Http\Controllers\Controller;
use App\Mail\PriceInquiryNotification;
use App\Models\Order;
use App\Models\Printview;
use App\Models\User;
use App\Notifications\UserNotification;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Notification;
use Validator;

class BuyerOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $id = Auth::user()->buyer_id;
        // $id = 2;
        $order = Order::select('id', 'updated_at', 'created_at', 'sendoutdate', 'status', 'group')->where('buyer', $id)->orderby('created_at', 'desc')->get();
        return response()->json($order, 200);
    }

    public function orderentrygetID($id)
    {
        $order = Order::with('product_group')->findOrFail($id);
        // dd($order->getRawOriginal('quantity_unit'));
        $order->quantity_units = $order->getRawOriginal('quantity_unit');
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
        $order = Order::find($id);

        // Determine the new status based on the action
        $newStatus = ($request->input('action') == 'reject') ? 'Printview Reject' : 'Order Confirm';

        // Only update and log if the status has changed
        if ($order->status !== $newStatus) {
            $order->status = $newStatus;
            $order->save();

            // Log the appropriate event based on the action
            switch ($request->input('action')) {
                case 'reject':
                    $this->logEvent('Order', "Order ID {$order->id} printview has been rejected.");
                    break;
                default:
                    $this->logEvent('Order', "Order ID {$order->id} printview has been accepted.");
                    break;
            }
        }



        return response()->json(['message' => 'PrintView saved successfully.'], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        //    dd($data);

        $validatedData = Validator::make($data, [
            'group' => 'required|string',
            'buyerorder' => 'nullable|string',
            'reference' => 'nullable|string',
            'inquiry' => 'nullable|string',
            'milungorder' => 'required|string',
            'orderdate' => 'required|date',
            'ftyitem' => 'nullable|string',
            'productname' => 'required|string',
            'productcolor' => 'nullable|string',
            'accessories' => 'required|string',
            'printingmethod' => 'required|string',
            'logocolor' => 'nullable|string',
            'packaging' => 'nullable|string',
            'packagingprinting' => 'nullable',
            'quantity' => 'required|string',
            'buyingprice' => 'nullable|integer',
            'sellingprice' => 'nullable|integer',
            'totalvalue' => 'nullable|integer',
            'sendoutdate' => 'required|date',
            'atc_number' => 'required|string',
            'ship_doc' => 'required|string',
            'incoterm' => 'required|string',
            'orderremarks' => 'nullable|string',
            'status' => 'required|string',
            'unit' => 'required|string',
        ]);

        if ($validatedData->fails()) {
            return response()->json(['errors' => $validatedData->errors()->all()], 422);
        }

        $data['quantity_unit'] = $data['quantity'] . $data['unit'];
        unset($data['quantity'], $data['quantity_units']);

        $data['capacity'] = array_map(function ($entry) {
            return $entry['quantity'] . $entry['unit'];
        }, $data['capacity']);

        if (isset($data['files'])) {
            $file = $data['files'];
            if ($file) {
                $fileNames = [];
                $fileName = time() . $file->getClientOriginalName();
                $filePath = $file->storeAs('orders/files', $fileName, 'public');
                $fileNames[] = ['filename' => $fileName, 'filepath' => $filePath];
            }
            $data['files'] = $fileNames;

        }
        $this->saveFiles($data, 'labelFiles');
        $this->saveFiles($data, 'logoFiles');
        $this->saveFiles($data, 'manualFiles');
        $this->saveFiles($data, 'safetySheetFiles');


        $data['linked_order'] = null;
        $user = Auth::user();
        if ($user->buyer_id) {

            $data['buyer'] = $user->buyer_id;
        }
        $order = Order::create($data);
        $order->status = 'New Order';
        $order->buyeremail = auth()->user()->email;
        $order->save();
        // Notification
        $admins = User::role(['Admin', 'Internal'])->get();

        $message = "A new order has been created by $user->name (User ID: {$user->userid}). Order ID: {$order->id}.";

        // Send the notification to the admins
        Notification::send($admins, new UserNotification($message, 'New Order', 'order_edit', ['id' => $order->id]));

        // Send the email to the admins
        foreach ($admins as $key => $admin) {
            Mail::to($admin->email)->send(new PriceInquiryNotification($message, 'New Order'));
        }

        return response()->json($order, 200);
    }

    private function saveFiles(&$data, $key)
    {
        if (!isset($data[$key])) {
            return;
        }
        if (isset($data[$key][0])) {
            $file = $data[$key][0];
        } else {
            unset($data[$key]);
            return;

        }
        unset($data[$key]);

        if (!$file['file']) {
            return;
        }

        $fileName = \Str::random(10) . '.' . $file['file']->getClientOriginalExtension();
        $filePath = $file['file']->storeAs('orders/' . $key, $fileName, 'public');
        $data[$key] = ['filename' => $file['fileName'], 'filepath' => $filePath];
    }

    /**
     * Store a newly created resource in storage.
     */


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
