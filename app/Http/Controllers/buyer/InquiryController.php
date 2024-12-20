<?php

namespace App\Http\Controllers\buyer;

use App\Http\Controllers\Controller;
use App\Mail\PriceInquiryNotification;
use App\Models\InquirySupplier;
use App\Models\PriceInquiry;
use App\Models\User;
use App\Notifications\UserNotification;
use Auth;
use DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Notification;

class InquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userid = auth()->user()->buyer_id;
        // $userid = 2;
        $prod = PriceInquiry::where('buyer', $userid)->orderby('created_at', 'desc')->get();

        return response()->json($prod, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'inquiry_number' => 'required|string',
            'article' => 'required|string',
            'group' => 'required|string',
            'name' => 'required|string',
            'description' => 'required|string',
            'cargo' => 'required|string',
            'cargo_place' => 'required|array',
            'cargo_place.*' => 'string',
            'incoterm' => 'required|string',
            'urgent' => 'nullable',
            'method' => 'required|string',
            'color' => 'nullable|string',
            'packaging' => 'nullable|string',
            'requirements' => 'nullable|string',
            'status' => 'required|string',
            'pcs' => 'required|array',
            'pcs.*' => 'integer',
            'supplier_ids.*' => 'integer',
            'capacity' => 'required|array',
            'capacity.*' => 'string',
        ]);
        try {
            DB::beginTransaction();
            $userid = Auth::user()->buyer_id;
            // dd($userid);

            // Auth::check() ? $validatedData['buyer'] = Auth::id() : 2;
            $validatedData['buyer'] = $userid;

            $priceInquiry = PriceInquiry::create($validatedData);

            if ($request->hasFile('file1')) {
                $file1 = $request->file('file1');
                $fileName1 = time() . '_' . $file1->getClientOriginalName();
                $file1->storeAs('public/files', $fileName1);
                $priceInquiry->file1 = $fileName1;
            }

            // Save materials data
            $pcs = $request->input('pcs');
            $priceInquiry->pcs = array_filter($pcs, function ($value) {
                return $value !== null;
            });

            // Save capacity data
            $capacity = $request->input('capacity');
            $priceInquiry->capacity = array_filter($capacity, function ($value) {
                return $value !== null && $value !== 'undefined';
            });


            $priceInquiry->save();

            // Notification
            $admins = User::role(['Admin', 'Internal'])->get();
            $inquiry_number = $validatedData['inquiry_number'];
            $messages = "A price inquiry with the number '$inquiry_number' has been added.";

            //Notification::send($admins, new UserNotification($messages, 'New Price Inquiry', 'price_inquiry_edit', ['id' => $priceInquiry->id]));

            Mail::to($admins->pluck('email'))->send(new PriceInquiryNotification($messages, 'New Price Inquiry'));

            DB::commit();
            return response()->json(['message' => 'Price inquiry submitted successfully'], 201);
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $userid = auth()->user()->buyer_id;
        // $userid = 2;
        $data['inquiry'] = PriceInquiry::where('buyer', $userid)->where('id', $id)->first();
        $data['supplierData'] = InquirySupplier::where('price_inquiry_id', $id)->where('selected', 1)->with('supplierremarks')->get();

        return response()->json($data, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function inquiry_followup($id)
    {
        $user = Auth::user();
        // dd($id);
        $admins = User::role(['Admin', 'Internal'])->get();
        $inquiry = PriceInquiry::where('id', $id)->where('buyer', $user->buyer_id)->first();
        $inquiry->status = 'ML Follow Up';
        $inquiry->save();
        // dd($InquirySupplier);
        if ($inquiry->inquiry_number) {

            $messages = "Buyer with User ID:'$user->userid' wanted to follow up on the recent addition of a price inquiry with the number '$inquiry->inquiry_number'. Could you please provide an update or any necessary actions required for this inquiry?";
            Notification::send($admins, new UserNotification($messages, 'Price Inquiry Follow Up', 'price_inquiry_edit', ['id' => $id]));

            foreach ($admins as $admin) {

                Mail::to($admin->email)->send(new PriceInquiryNotification($messages, 'Price Inquiry Follow Up'));
            }
            $inquiry->status = 'Buyer Follow Up';
            $inquiry->save();
            $this->logEvent('Inquiry', 'Price Inquiry# ' . $inquiry->inquiry_number . ' follow up. ');
        }
        return response()->json(['message' => 'Follow up sent successfully']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // dd($request->all(), $id);
        $validatedData = $request->validate([
            'inquiry_number' => 'required|string',
            'article' => 'required|string',
            'group' => 'required|string',
            'name' => 'required|string',
            'description' => 'required|string',
            'cargo' => 'required|string',
            'cargo_place' => 'required|array',
            'cargo_place.*' => 'string',
            'incoterm' => 'required|string',
            'urgent' => 'nullable',
            'method' => 'required|string',
            'color' => 'nullable|string',
            'packaging' => 'nullable|string',
            'requirements' => 'nullable|string',
            'status' => 'required|string',
            'pcs' => 'required|array',
            'pcs.*' => 'integer',
            'supplier_ids.*' => 'integer',
            'capacity' => 'required|array',
            'capacity.*' => 'string',
        ]);

        $priceInquiry = PriceInquiry::findOrFail($id);
        $priceInquiry->update($validatedData);

        if ($request->hasFile('file1')) {
            $file1 = $request->file('file1');
            $fileName1 = time() . '_' . $file1->getClientOriginalName();
            $file1->storeAs('public/files', $fileName1);
            $priceInquiry->file1 = $fileName1;
        }

        // Save materials data
        $pcs = $request->input('pcs');
        $priceInquiry->pcs = array_filter($pcs, function ($value) {
            return $value !== null;
        });

        // Save capacity data
        $capacity = $request->input('capacity');
        $priceInquiry->capacity = array_filter($capacity, function ($value) {
            return $value !== null && $value !== 'undefined';
        });

        Auth::check() ? $priceInquiry->buyer = Auth::user()->buyer_id : 2;

        $priceInquiry->status = 'ML Checking';
        $priceInquiry->save();

        return response()->json(['message' => 'Price inquiry submitted successfully'], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $user = PriceInquiry::findOrFail($id);
            $user->delete();

            return response()->json(['message' => 'Inquiry deleted successfully'], 200);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
