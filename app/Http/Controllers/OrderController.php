<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    public function orderentry(Request $request)
    {
        $data = $request->all()[0];

        $validatedData = Validator::make($data, [
            'group' => 'required|string',
            'article' => 'required|string',
            'buyerorder' => 'required|string',
            'reference' => 'required|string',
            'inquiry' => 'required|string',
            'milungorder' => 'required|string',
            'supplier' => 'required|string',
            'orderdate' => 'required|date',
            'buyeremail' => 'required|email',
            'buyer' => 'required|string',
            'ftyitem' => 'required|string',
            'productname' => 'required|string',
            'productcolor' => 'required|string',
            'accessories' => 'required|string',
            'printingmethod' => 'required|string',
            'logocolor' => 'required|string',
            'packaging' => 'required|string',
            'packagingprinting' => 'required|string',
            'quantity' => 'required|string',
            'buyingprice' => 'required|string',
            'sellingprice' => 'required|string',
            'totalvalue' => 'required|string',
            'sendoutdate' => 'required|date',
            'so_number' => 'required|string',
            'atc_number' => 'required|string',
            'ship_doc' => 'required|string',
            'incoterm' => 'required|string',
            'orderremarks' => 'required|string',
            'qcremarks' => 'required|string',
            'status' => 'required|string',
            'unit' => 'required|string',
        ]);

        if ($validatedData->fails()) {
            return response()->json(['errors' => $validatedData->errors()->all()], 422);
        }

        $data['quantity_unit'] = $data['quantity'] . $data['unit'];
        unset($data['quantity'], $data['unit']);

        $data['capacity'] = array_map(function ($entry) {
            return $entry['quantity'] . ' ' . $entry['unit'];
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

        return response()->json($order, 201);
    }

    private function saveFiles(&$data, $key)
    {
        if (!isset($data[$key])) {
            return;
        }

        $file = $data[$key][0];
        unset($data[$key]);

        if (!$file['file']) {
            return;
        }

        $fileName = Str::random(10) . '.' . $file['file']->getClientOriginalExtension();
        $filePath = $file['file']->storeAs('orders/' . $key, $fileName, 'public');
        $data[$key] = ['filename' => $fileName, 'filepath' => $filePath];
    }
}
