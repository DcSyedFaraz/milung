<?php

namespace App\Http\Controllers;

use App\Mail\PriceInquiryNotification;
use App\Models\Information;
use App\Models\Order;
use App\Models\OrderSupplier;
use App\Models\Products;
use App\Models\SupplierProfile;
use App\Models\User;
use App\Notifications\UserNotification;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Notification;

class OrderController extends Controller
{
    public function orderentryget()
    {
        $order = Order::with('buyerid', 'shipmentOrders', 'supplierid', 'product_group')->orderby('created_at', 'desc')->get();
        return response()->json($order, 200);
    }
    public function article()
    {
        $order = Products::pluck('article');
        return response()->json($order, 200);
    }
    public function Suppliers()
    {
        $users = SupplierProfile::select('id', 'supplier_id')->get();
        return response()->json($users, 200);
    }
    public function placeAll(Request $request)
    {
        $data = $request->all();

        if (empty($data)) {
            return response()->json(['errors' => 'Request Is Empty'], 422);
        }

        foreach ($data as $orderData) {
            $orderId = $orderData['orderId'];
            $supplierId = $orderData['supplierId'];

            $order_place = OrderSupplier::where('order_id', $orderId)
                ->where('user_id', $supplierId)
                ->first();

            // Check if $order_place exists
            if ($order_place) {
                if ($order_place->purchase !== null) {
                    $order = Order::find($orderId);

                    $quantityValue = (int) preg_replace('/[^0-9]/', '', $order->quantity_unit);
                    $order->buyingprice = $order_place->purchase;
                    $order->supplier = $supplierId;

                    $purchaseNumeric = floatval($order_place->purchase); // Convert to numeric value

                    if ($order->product_group->amount !== 0) {
                        $selling = $purchaseNumeric + $order->product_group->amount;
                    } else {
                        $selling = $purchaseNumeric + ($purchaseNumeric * $order->product_group->profit / 100);
                    }

                    $order->sellingprice = $selling;
                    $order->totalvalue = $selling * $quantityValue;
                    $order->assigned_to_supplier_at = Carbon::now();
                    $order->save();

                    $user = User::where('supplier_id', $supplierId)->get();
                    // Notification
                    $message = "Dear Supplier, an admin has placed an order with the ID #$orderId. Please review the details at your earliest convenience.";

                    $route = 'supplier_order_edit';
                    $routeParams = ['id' => $orderId];
                    // Send the notification to the supplier
                    Notification::send($user, new UserNotification($message, 'New Order', $route, $routeParams));

                    // Send the email to the supplier
                    foreach ($user as $value) {
                        Mail::to($value->email)->send(new PriceInquiryNotification($message, 'New Order'));
                    }

                } else {
                    return response()->json(['message' => 'The supplier has not provided a price quote yet.', 'success' => false], 200);
                }

            } else {
                return response()->json(['message' => 'Order not found', 'success' => false], 404);
            }
        }

        return response()->json(['message' => 'Orders placed successfully', 'success' => true], 200);
    }
    public function supplierPlace(Request $request)
    {
        $data = $request->all();
        // $id = 3;
        $user = Auth::user();

        if (empty($data)) {
            return response()->json(['errors' => 'Request Is Empty'], 422);
        }

        //    return $data;
        $admins = User::role(['Admin', 'Internal'])->get();

        foreach ($data as $orderData) {
            $orderId = $orderData['orderId'];

            $order_place = OrderSupplier::where('order_id', $orderId)
                ->where('user_id', $user->supplier_id)
                ->first();

            // Check if $order_place exists
            if ($order_place) {
                if ($order_place->purchase == null) {

                    $order_place->purchase = $orderData['selling_price'];
                    $order_place->remarks = $orderData['remarks'];
                    $order_place->save();

                    // Notification
                    $message = "$user->name (User ID: $user->userid) has submitted a price inquiry for order #$orderId.";

                    $route = 'order_price_inquiry';
                    // Send the notification to the supplier
                    Notification::send($admins, new UserNotification($message, 'Order Price Inquiry', $route));

                    // Send the email to the supplier
                    foreach ($admins as $key => $admin) {
                        \Mail::to($admin->email)->send(new PriceInquiryNotification($message, 'Order Price Inquiry'));
                    }
                } else {
                    return response()->json(['message' => 'You already provided a price quote.', 'success' => false], 200);
                }

            } else {
                return response()->json(['message' => 'Order not found', 'success' => false], 404);
            }
        }

        return response()->json(['message' => 'Price quoted successfully', 'success' => true], 200);
    }

    public function saveSelectedOrders(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'selectedOrderIds' => 'required|array',
            'selectedOrderIds.*' => 'exists:orders,id', // Ensure all order IDs exist in the orders table
            'selectedSupplierIds' => 'required|array',
            'selectedSupplierIds.*' => 'exists:users,id', // Ensure all supplier IDs exist in the suppliers table
        ]);

        // Extract the validated data
        $selectedOrderIds = $validatedData['selectedOrderIds'];
        $selectedSupplierIds = $validatedData['selectedSupplierIds'];

        $orderList = implode(', ', $selectedOrderIds);
        $message = "A new price inquiry has been received for the following order(s): $orderList. Please review and provide a quote as soon as possible.";
        $route = 'supplier_order_price_inquiry';

        try {
            foreach ($selectedOrderIds as $orderId) {
                foreach ($selectedSupplierIds as $supplierId) {
                    // Check if the combination of order ID and supplier ID already exists
                    $existingRecord = OrderSupplier::where('order_id', $orderId)
                        ->where('user_id', $supplierId)
                        ->exists();
                    // Save order-supplier relationship in the pivot table
                    if (!$existingRecord) {
                        OrderSupplier::create([
                            'order_id' => $orderId,
                            'user_id' => $supplierId,
                        ]);

                        $supplier = User::where('supplier_id', $supplierId)->get();


                        Notification::send($supplier, new UserNotification($message, 'New Order Price Inquiry', $route));

                        foreach ($supplier as $key => $user) {
                            Mail::to($user->email)->send(new PriceInquiryNotification($message, 'New Order Price Inquiry'));
                        }

                    }
                    Order::where('id', $orderId)->update([
                        'status' => 'Price',
                    ]);
                }
            }

            $this->logEvent('Order', "Price inquiry has been sent for the following order(s): $orderList.");
            // Return success response
            return response()->json(['message' => 'Inquiry sent successfully'], 200);
        } catch (\Exception $e) {
            // Return error response if an exception occurs
            return response()->json(['message' => 'Failed to save data', 'error' => $e->getMessage()], 500);
        }
    }
    public function orderAll()
    {
        $orders = Order::whereHas('orderSuppliers')->orderby('created_at', 'desc')->with(['orderSuppliers', 'orderSuppliers.user', 'product_group'])->where(function ($query) {
            $query->whereNull('buyingprice')
                ->orWhere('buyingprice', '=', '');
        })->get();
        foreach ($orders as $order) {
            // dd($order->files);
            if ($order->files && $order->files != null) {
                $filePath = $order->files[0]['filepath']; // Replace 'filepath' with your actual field name
                // Generate the thumbnail URL
                $thumbnailUrl = Storage::url($filePath) . '?thumbnail=true';
                // dd($thumbnailUrl);

                // Append the thumbnail URL to the order object
                $order->thumbnail_url = $thumbnailUrl;
            }
        }
        return response()->json($orders, 200);
    }
    public function SupplierOrder()
    {
        $user = Auth::user();

        // Retrieve order_ids from the orderSuppliers table where the user ID matches the authenticated user's ID
        $orderIds = OrderSupplier::where('user_id', $user->supplier_id)->whereNull('purchase')
            ->pluck('order_id')
            ->toArray();
        // dd($user->supplier_id);
        // Retrieve orders where the order_id is present in the array of order_ids
        $orders = Order::whereIn('id', $orderIds)->with('product_group', 'orderSuppliersOnly')
            ->get();
        foreach ($orders as $order) {
            // dd($order->files);
            if ($order->files && $order->files != null) {
                $filePath = $order->files[0]['filepath']; // Replace 'filepath' with your actual field name
                // Generate the thumbnail URL
                $thumbnailUrl = Storage::url($filePath) . '?thumbnail=true';
                // dd($thumbnailUrl);

                // Append the thumbnail URL to the order object
                $order->thumbnail_url = $thumbnailUrl;
            }
            // dd($user->supplierProfile);
            $order->userid = $user->supplierProfile->supplier_id;
        }
        return response()->json($orders, 200);
    }
    public function orderUpdate(Request $request, $id)
    {
        $data = $request->all();
        $existingOrder = Order::findOrFail($id);
        //    dd($data);

        $validatedData = $request->validate([
            'group' => 'required|string',
            'article' => 'nullable|string|exists:products,article',
            'buyerorder' => 'nullable|string',
            'reference' => 'nullable|string',
            'inquiry' => 'nullable|string',
            'milungorder' => 'required|string',
            'supplier' => 'exists:supplier_profiles,id',
            'buyer' => 'required|exists:buyer_profiles,id',
            'orderdate' => 'required|date',
            'buyeremail' => 'required|email',
            'ftyitem' => 'nullable|string',
            'productname' => 'required|string',
            'productcolor' => 'nullable|string',
            'accessories' => 'required|string',
            'printingmethod' => 'required|string',
            'logocolor' => 'nullable',
            'packaging' => 'nullable|string',
            'packagingprinting' => 'nullable',
            'quantity' => 'required|string',
            'buyingprice' => 'nullable',
            'sellingprice' => 'nullable',
            'totalvalue' => 'nullable',
            'sendoutdate' => 'required|date',
            'so_number' => 'nullable',
            'atc_number' => 'nullable|string',
            'orderremarks' => 'nullable|string',
            'qcremarks' => 'nullable|string',
            'status' => 'required|string',
            'unit' => 'required|string',
            'linked_order' => 'nullable|string',
        ]);

        // if ($validatedData->fails()) {
        //     return response()->json(['errors' => $validatedData->errors()->all()], 422);
        // }

        $data['quantity_unit'] = $data['quantity'];
        unset($data['quantity'], $data['quantity_units']);

        $data['capacity'] = array_map(function ($entry) {
            return $entry['quantity'] . $entry['unit'];
        }, $data['capacity']);

        if (isset($data['files']) && $existingOrder->files != $data['files']) {
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

        $originalData = $existingOrder->toArray();

        if ($validatedData['linked_order'] === 'create') {
            $data['linked_order'] = $data['id'];
            // dd( $validatedData['linked_order']);
            unset($data['id']);
            $order = Order::create($data);
        } else {
            $data['linked_order'] = null;
            $order = $existingOrder->update($data);

        }

        $updatedData = $existingOrder->toArray();

        // Capture the names of the fields that have changed
        $changedFields = [];
        foreach ($updatedData as $key => $value) {
            if ($key !== 'updated_at' && isset($originalData[$key]) && $originalData[$key] != $value) {
                $changedFields[] = ucfirst(str_replace('_', ' ', $key)); // Convert snake_case to readable format
            }
        }

        // Log the updated fields in a user-friendly way
        if (!empty($changedFields)) {
            $updatedFieldsList = implode(', ', $changedFields);
            $this->logEvent('Order', "Order ID {$existingOrder->id} has been updated. Updated fields: {$updatedFieldsList}");
        } else {
            // If no changes, log a generic message
            $this->logEvent('Order', "Order ID {$existingOrder->id} has been updated with no fields changed.");
        }

        return response()->json($order, 201);
    }
    public function orderentrygetID($id)
    {
        $order = Order::findOrFail($id);
        // dd($order->getRawOriginal('quantity_unit'));
        $order->quantity_units = $order->getRawOriginal('quantity_unit');
        return response()->json($order, 200);
    }
    public function orderentry(Request $request)
    {
        $data = $request->all();
        // dd($data);


        $validatedData = $request->validate([
            'group' => 'required|string',
            'article' => 'nullable|string|exists:products,article',
            'buyerorder' => 'required|string',
            'reference' => 'nullable|string',
            'inquiry' => 'nullable|string',
            'milungorder' => 'required|string',
            'supplier' => 'exists:supplier_profiles,id',
            'buyer' => 'required|exists:buyer_profiles,id',
            'orderdate' => 'required|date',
            'buyeremail' => 'required|email',
            'ftyitem' => 'nullable|string',
            'productname' => 'required|string',
            'productcolor' => 'nullable|string',
            'accessories' => 'required|string',
            'printingmethod' => 'required|string',
            'logocolor' => 'nullable',
            'packaging' => 'nullable|string',
            'packagingprinting' => 'nullable',
            'quantity' => 'required|string',
            'buyingprice' => 'nullable',
            'sellingprice' => 'nullable',
            'totalvalue' => 'nullable',
            'sendoutdate' => 'required|date',
            'so_number' => 'nullable',
            'atc_number' => 'nullable|string',
            'orderremarks' => 'nullable|string',
            'qcremarks' => 'nullable|string',
            'status' => 'required|string',
            'unit' => 'required|string',
        ]);

        // if ($validatedData->fails()) {
        //     return response()->json(['errors' => $validatedData->errors()->all()], 422);
        // }

        $data['quantity_unit'] = $data['quantity'];
        unset($data['quantity']);
        // dd($data['quantity_unit']);
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

        $order = Order::create($data);
        $this->logEvent('Order', "Order ID {$order->id} has been created.");

        return response()->json($order, 201);
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

        $fileName = Str::random(10) . '.' . $file['file']->getClientOriginalExtension();
        $filePath = $file['file']->storeAs('orders/' . $key, $fileName, 'public');
        $data[$key] = ['filename' => $file['fileName'], 'filepath' => $filePath];
    }
    public function orderDelete($id)
    {
        // dd($id);
        try {
            $user = Order::findOrFail($id);
            $user->delete();
            $this->logEvent("Order", "Order ID '$id' has been deleted.");
            return response()->json(['message' => 'Order deleted successfully'], 200);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
