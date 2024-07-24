<?php

namespace App\Http\Controllers\supplier;

use App\Http\Controllers\Controller;
use App\Mail\PriceInquiryNotification;
use App\Models\PriceInquiry;
use App\Models\ProductGroup;
use App\Models\Products;
use App\Models\SupplierRemarks;
use App\Models\User;
use App\Notifications\UserNotification;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SuppProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function price_inquiry(Request $request)
    {
        $id = Auth::user()->supplier_id;
        // $id = 3;
        // dd($request->all(), $request->price);

        $validatedData = $request->validate([
            'remarks' => 'nullable',
            'exws.*.quantity' => 'required|string',
            'exws.*.capacity' => 'required|string',
            'exws.*.exw' => 'required|numeric',
            'image' => 'nullable|image',
        ]);

        $priceInquiry = PriceInquiry::findOrFail($id);

        // Handle file uploads

        if ($request->hasFile('file1')) {
            $file1 = $request->file('file1');
            $fileName1 = time() . '_' . $file1->getClientOriginalName();
            $file1->storeAs('public/files', $fileName1);
            $priceInquiry->file1 = $fileName1;
        }

        foreach ($request->price as $index => $data) {
            // Find the corresponding inquiry supplier record
            $inquirySupplier = $priceInquiry->inquirysuppliers()
                ->where('user_id', $data->user_id)
                ->where('quantity', $data->quantity)
                ->where('capacity', $data->capacity)
                ->first();

            // Update the exw value if the record exists
            if ($inquirySupplier) {
                $inquirySupplier->update([
                    'exw' => $data->exw,
                ]);
            }
        }




        return response()->json(['message' => 'Quote submitted successfully'], 201);
    }
    public function update_price_inquiry(Request $request, $id)
    {
        // dd($request->all(), $request->price);
        $userId = Auth::user()->supplier_id;
        // $userId = 3;
        $validatedData = $request->validate([
            'remarks' => 'required',
            'exws.*.quantity' => 'required|string',
            'exws.*.capacity' => 'required|string',
            'exws.*.exw' => 'required|numeric',
            'image' => 'nullable|image',
        ]);

        $priceInquiry = PriceInquiry::findOrFail($id);
        SupplierRemarks::updateOrCreate(
            ['price_inquiry_id' => $id, 'user_id' => $userId],
            ['remarks' => $request->input('remarks')]
        );

        // Handle file uploads

        if ($request->hasFile('image')) {
            $file1 = $request->file('image');
            $fileName1 = time() . '_' . $file1->getClientOriginalName();
            $file1->storeAs('public/files', $fileName1);
            $priceInquiry->file1 = $fileName1;

            $priceInquiry->save();
        }
        foreach ($request->price as $index => $data) {
            // Find the corresponding inquiry supplier record
            $inquirySupplier = $priceInquiry->inquirysuppliers()
                ->where('user_id', $data['user_id'])
                ->where('quantity', $data['quantity'])
                ->where('capacity', $data['capacity'])
                ->first();

            // Update the exw value if the record exists
            if ($inquirySupplier) {
                $inquirySupplier->update([
                    'exw' => $data['exw'],
                ]);
            }
        }
        $inquiry_number = $priceInquiry->inquiry_number;
        $admins = User::role(['Admin', 'Internal'])->get();
        $userid = auth()->user()->userid;

        $message = "Hi there! We wanted to let you know that one of your suppliers with user ID: $userid has sent a quote for the price inquiry with the number '$inquiry_number'.";

        // Send notification
        \Notification::send($admins, new UserNotification($message, 'Price Inquiry Quote', 'price_inquiry_edit', ['id' => $priceInquiry->id]));

        // Send email
        \Mail::to($admins->pluck('email'))->send(new PriceInquiryNotification($message, 'Price Inquiry Quote'));

        return response()->json(['message' => 'Quote submitted successfully'], 201);
    }

    /**
     * Show the form for creating a new resource.
     */

    public function price_inquiry_get()
    {
        $id = Auth::user()->supplier_id;
        // $id = 3;
        $priceInquiries = PriceInquiry::
            whereHas('inquirysuppliers', function ($query) use ($id) {
                $query->where('user_id', $id);
            })
            ->orderBy('created_at', 'desc')->get();



        return response()->json($priceInquiries, 200);
    }
    public function price_inquiry_getOne($id)
    {
        $userId = Auth::user()->supplier_id;
        // $userId = 3; // Assuming the user ID is hardcoded for demonstration

        $priceInquiry = PriceInquiry::where('id', $id)->with([
            'product_group',
            'inquirysuppliers' => function ($query) use ($userId) {
                $query->where('user_id', $userId);
            }
        ])
            ->whereHas('inquirysuppliers', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->first();
        $remarks = SupplierRemarks::where('price_inquiry_id', $id)
            ->where('user_id', $userId)
            ->first();

        $priceInquiry->remarks = $remarks;

        if (!$priceInquiry) {
            return response()->json(['error' => 'Price inquiry not found or not assigned to the user.'], JsonResponse::HTTP_NOT_FOUND);
        }

        return response()->json($priceInquiry, 200);
    }

}
