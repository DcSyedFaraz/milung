<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\PriceInquiry;
use App\Models\ProductGroup;
use App\Models\Products;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function price_inquiry(Request $request)
    {

        // dd($request->all());

        $validatedData = $request->validate([
            'supplier_ids' => 'array|exists:users,id',
            'buyer' => 'required|exists:users,id',
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

        $priceInquiry = PriceInquiry::create($validatedData);

        // Handle file uploads
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/files', $fileName);
            $priceInquiry->file = $fileName;
        }
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

        Auth::check() ? $priceInquiry->user_id = Auth::id() : '';

        $priceInquiry->save();

        return response()->json(['message' => 'Price inquiry submitted successfully'], 201);
    }
    public function update_price_inquiry(Request $request, $id)
    {
        // dd($request->all(),$id);
        // Validate the incoming request data
        $validatedData = $request->validate([
            'supplier_ids' => 'array|exists:users,id',
            'buyer' => 'required|exists:users,id',
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

        // Find the PriceInquiry record by ID
        $priceInquiry = PriceInquiry::findOrFail($id);

        // Update the fields with the validated data
        $priceInquiry->update($validatedData);

        // Handle file uploads if necessary
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/files', $fileName);
            $priceInquiry->file = $fileName;
        }
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

        // Auth::check() ? $priceInquiry->user_id = Auth::id() : '';

        $priceInquiry->save();

        // Return a success response
        return response()->json(['message' => 'Price inquiry updated successfully'], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function product_group_get()
    {
        $prod = ProductGroup::select('id', 'group_name','hs_de','hs_cn')->get();
        // $formattedProducts = $prod->map(function ($product) {
        //     // Assuming the datetime fields are named 'created_at' and 'updated_at'
        //     $product->created_at = Carbon::parse($product->created_at)->toDateString(); // Adjust format as needed
        //     $product->updated_at = Carbon::parse($product->updated_at)->toDateString(); // Adjust format as needed
        //     return $product;
        // });

        // Return the formatted ProductGroup collection as JSON response
        return response()->json($prod, JsonResponse::HTTP_OK);
    }
    public function product_group_get_all()
    {
        $prod = ProductGroup::orderby('created_at', 'desc')->get();
        // $formattedProducts = $prod->map(function ($product) {
        //     // Assuming the datetime fields are named 'created_at' and 'updated_at'
        //     $product->created_at = Carbon::parse($product->created_at)->toDateString(); // Adjust format as needed
        //     $product->updated_at = Carbon::parse($product->updated_at)->toDateString(); // Adjust format as needed
        //     return $product;
        // });

        // Return the formatted ProductGroup collection as JSON response
        return response()->json($prod, JsonResponse::HTTP_OK);
    }
    public function price_inquiry_get()
    {
        $prod = PriceInquiry::orderby('created_at', 'desc')->get();

        return response()->json($prod, JsonResponse::HTTP_OK);
    }
    public function PriceDelete($id)
    {
        // dd($id);
        try {
            $user = PriceInquiry::findOrFail($id);
            $user->delete();

            return response()->json(['message' => 'Inquiry deleted successfully'], 200);
        } catch (\Exception $e) {
            throw $e;
        }
    }
    public function statement(Request $request)
    {
        dd($request->all());
    }
    public function product_group(Request $request)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'group_name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'profit' => 'nullable',
            'amount' => 'nullable',
            'hs_de' => 'required|integer',
            'hs_cn' => 'required|integer',
        ]);

        $product = new ProductGroup();
        $product->group_name = $validatedData['group_name'];
        $product->description = $validatedData['description'];
        $product->profit = $validatedData['profit'];
        $product->amount = $validatedData['amount'];
        $product->hs_de = $validatedData['hs_de'];
        $product->hs_cn = $validatedData['hs_cn'];
        $product->save();

        return response()->json(['message' => 'Product created successfully']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function addprod(Request $request)
    {
        // dd(auth()->user()->id);
        // dd($request->all());
        // In your controller's validation method
        try {
            $validatedData = $request->validate([
                'article' => 'required|max:255',
                'status' => 'required',
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'group' => 'nullable|integer|max:255',
                'cargo' => 'nullable|string|max:255',
                'cargo_place' => 'nullable',
                'color' => 'nullable|string|max:255',
                'material' => 'nullable|string|max:255',
                'size' => 'nullable|string|max:255',
                'weight' => 'nullable|string|max:255',
                'specification' => 'nullable|string',
                'memory' => 'nullable|string|max:255',
                'feature' => 'nullable|string|max:255',
                'accessory' => 'nullable|string|max:255',
                'accessory_weight' => 'nullable|string|max:255',
                'battery_type' => 'nullable|string|max:255',
                'rated' => 'nullable|string|max:255',
                'capacity' => 'nullable|string|max:255',
                'voltage' => 'nullable|string|max:255',
                'pcs' => 'nullable|integer',
                'mAh' => 'nullable|string|max:255',
                'mm' => 'nullable|string|max:255',
                'gram' => 'nullable|string|max:255',
                'edition' => 'nullable|string|max:255',
                'msds_expiry' => 'nullable|date',
                'un_expiry' => 'nullable|date',
                'air_safety_expiry' => 'nullable|date',
                'sea_safety_expiry' => 'nullable|date',
                'train_safety_expiry' => 'nullable|date',
                'certificate' => 'nullable|string|max:255',
                'printing_method' => 'nullable|string|max:255',
                'unit_packaging_paper' => 'nullable|integer',
                'unit_packaging_plastic' => 'nullable|integer',
                'unit_packaging_metal' => 'nullable|integer',
                'unit_packaging_others' => 'nullable|integer',
                'packaging_material' => 'nullable|string|max:255',
                'packaging_weight' => 'nullable|integer',
                'standart_packaging' => 'nullable|string|max:255',
                'safety_sheet' => 'nullable|file',
                'manual' => 'nullable|file',
                'product_label' => 'nullable|file',
                'packaging_label' => 'nullable|file',
            ]);

            $product = Products::create($validatedData);

            // Save images
            if ($request->file('images')) {
                foreach ($request->file('images') as $image) {
                    $fileName = \Str::random(5) . $image->getClientOriginalName();
                    $path = $image->storeAs('images', $fileName, 'public');
                    // $path = $image->store('images', 'public');
                    // Attach image to the product
                    $product->images()->create(['path' => $path, 'name' => $image->getClientOriginalName()]);
                }
            }

            // Save other files
            $safetySheetPath = $request->file('safety_sheet') ? $request->file('safety_sheet')->store('safety_sheets', 'public') : null;
            $manualPath = $request->file('manual') ? $request->file('manual')->store('manuals', 'public') : null;
            $productLabelPath = $request->file('product_label') ? $request->file('product_label')->store('product_labels', 'public') : null;
            $packagingLabelPath = $request->file('packaging_label') ? $request->file('packaging_label')->store('packaging_labels', 'public') : null;

            // Attach file paths to the product
            $product->update([
                'safety_sheet' => $safetySheetPath,
                'manual' => $manualPath,
                'product_label' => $productLabelPath,
                'packaging_label' => $packagingLabelPath,
                'user_id' => auth()->user()->id ?? '',
            ]);


            return response()->json(['message' => 'Product saved successfully'], 201);
        } catch (\Exception $e) {
            throw $e;
        }

    }

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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function prodDelete($id)
    {
        // dd($id);
        try {

            $user = Products::findOrFail($id);
            $user->delete();
            return response()->json(['message' => 'Product deleted successfully'], 200);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
