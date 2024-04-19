<?php

namespace App\Http\Controllers\buyer;

use App\Http\Controllers\Controller;
use App\Models\PriceInquiry;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $userid = auth()->user()->id;
        $userid = 2;
        $prod = PriceInquiry::where('buyer', $userid)->orderby('created_at', 'desc')->get();

        return response()->json($prod, JsonResponse::HTTP_OK);
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
            'incoterm' => 'required|string',
            'urgent' => 'nullable',
            'method' => 'required|string',
            'color' => 'required|string',
            'packaging' => 'required|string',
            'requirements' => 'required|string',
            'status' => 'required|string',
            'pcs' => 'required|array',
            'capacity' => 'required|array',
        ]);

        $userid = 2;
        // $userid = Auth::id();
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

        Auth::check() ? $priceInquiry->buyer = Auth::id() : 2;

        $priceInquiry->save();

        return response()->json(['message' => 'Price inquiry submitted successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // $userid = auth()->user()->id;
        $userid = 2;
        $prod = PriceInquiry::where('buyer', $userid)->where('id', $id)->first();

        return response()->json($prod, JsonResponse::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
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
            'incoterm' => 'required|string',
            'urgent' => 'nullable',
            'method' => 'required|string',
            'color' => 'required|string',
            'packaging' => 'required|string',
            'requirements' => 'required|string',
            'status' => 'required|string',
            'pcs' => 'required|array',
            'capacity' => 'required|array',
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

        Auth::check() ? $priceInquiry->buyer = Auth::id() : 2;

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
