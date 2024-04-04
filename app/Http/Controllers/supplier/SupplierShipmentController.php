<?php

namespace App\Http\Controllers\supplier;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\PackingList;
use App\Models\ShipmentOrder;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SupplierShipmentController extends Controller
{
    public function suppliershipments()
    {
        $id = 3;
        // $id = Auth::user()->id;
        $shipment = ShipmentOrder::whereHas('orders', function ($query) use ($id) {
            $query->where('supplier', $id);
        })->select('id', 'so_number')->get();
        return response()->json($shipment, JsonResponse::HTTP_OK);
    }
    public function shipments()
    {
        $id = 3;
        // $id = Auth::user()->id;
        $shipment = ShipmentOrder::whereHas('orders', function ($query) use ($id) {
            $query->where('supplier', $id);
        })->get();
        return response()->json($shipment, JsonResponse::HTTP_OK);
    }
    public function suppliershipment($id)
    {
        // dd($id);
        // $userid = Auth::user()->id;
        $userid = 3;
        $shipment = Order::where('so_number', $id)->where('supplier', $userid)->select('id', 'so_number', 'supplier', 'group', 'quantity_unit')->with('product_group', 'packinglist')->get();
        return response()->json($shipment, JsonResponse::HTTP_OK);
    }
    public function suppliershipmentUpdate($id, Request $request)
    {

        $userId = 8;
        // $userId = Auth::user()->id;

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
                ['user_id' => $userId, 'order_id' => $id, 'shipment_order_id' => $request->so_number],
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
    public function infosave($id, Request $request)
    {

        // dd($request->all());
        $userId = 8;

        // if (Auth::user()->hasRole('admin')) {
        //     $userId = $request->input('user_id');
        // } else {
        //     $userId = Auth::user()->id;
        // }

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
