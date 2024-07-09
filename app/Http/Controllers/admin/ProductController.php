<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Mail\PriceInquiryNotification;
use App\Mail\ProductNotification;
use App\Models\InquirySupplier;
use App\Models\PriceInquiry;
use App\Models\ProductGroup;
use App\Models\ProductImages;
use App\Models\Products;
use App\Models\User;
use App\Notifications\UserNotification;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Mail;
use Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function product_group_id($id)
    {
        $prod = ProductGroup::where('id', $id)->with('additionalFields')->first();
        return response()->json($prod, 200);
    }
    public function product_group_update(Request $request, $id)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'group_name' => 'required|string|max:255|unique:product_groups,group_name,' . $id,
            'description' => 'required|string|max:255',
            'profit' => 'nullable',
            'amount' => 'nullable|numeric|max:99999999.99',
            'hs_de' => 'required|integer',
            'hs_cn' => 'required|integer',
            'additionalFields' => 'array', // Validate additional fields as an array
            'additionalFields.*.name' => 'required|string|max:255', // Validate each additional field's name
            'additionalFields.*.value' => 'required|string|max:255',
        ]);
        try {
            // Start a database transaction
            DB::beginTransaction();
            $product = ProductGroup::findOrFail($id);
            $product->group_name = $validatedData['group_name'];
            $product->description = $validatedData['description'];
            $product->profit = $validatedData['profit'];
            $product->amount = $validatedData['amount'];
            $product->hs_de = $validatedData['hs_de'];
            $product->hs_cn = $validatedData['hs_cn'];
            $product->save();

            $product->additionalFields()->delete();


            // Save additional fields if they exist
            if (isset($validatedData['additionalFields'])) {
                foreach ($validatedData['additionalFields'] as $field) {
                    $product->additionalFields()->create([
                        'name' => $field['name'],
                        'value' => $field['value']
                    ]);
                }
            }
            // Notification
            $admins = User::role(['Admin', 'Internal'])->get();
            $productName = e($validatedData['group_name']);
            $message = "A product group with the name '$productName' has been updated.";

            $this->logEvent('Group', $message);
            \Notification::send($admins, new UserNotification($message, 'Product Group Updated', 'product'));

            DB::commit();

            // Return a success response or redirect
            return response()->json(['message' => 'Product group saved successfully!']);
        } catch (\Exception $e) {
            DB::rollBack();

            // \Log::error($e->getMessage());

            return response()->json(['message' => 'An error occurred while saving the product group.' . $e->getMessage()], 500);
        }
    }
    public function inquiry_followup($id)
    {
        $InquirySupplier = InquirySupplier::where('price_inquiry_id', $id)->pluck('user_id');
        $inquiry_number = PriceInquiry::where('id', $id)->value('inquiry_number');
        // dd($InquirySupplier);
        if ($InquirySupplier) {

            $messages = "Admin wanted to follow up on the recent addition of a price inquiry with the number '$inquiry_number'. Could you please provide an update or any necessary actions required for this inquiry?";
            foreach ($InquirySupplier as $supplierId) {
                // Get the supplier
                $supplier = User::where('id', $supplierId)->first();
                // dd($supplier->email);
                // Send the notification to the supplier
                \Notification::send($supplier, new UserNotification($messages, 'Price Inquiry Follow Up', 'supplier_price_inquiry_entry', ['id' => $id]));

                // Send the email to the supplier
                Mail::to($supplier->email)->send(new PriceInquiryNotification($messages, 'Price Inquiry Follow Up'));
            }
        }
        return response()->json(['message' => 'Follow up sent successfully']);
    }
    public function price_inquiry(Request $request)
    {

        // dd($request->all());

        $validatedData = $request->validate([
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
            'supplier_ids' => 'required|array',
        ]);

        try {


            $priceInquiry = PriceInquiry::create($validatedData);

            if ($request->supplier_ids) {

                $inquiry_number = $validatedData['inquiry_number'];
                $messages = "A price inquiry with the number '$inquiry_number' has been added.";
                foreach ($request->supplier_ids as $supplierId) {
                    // Get the supplier
                    $supplier = User::find($supplierId);

                    // Send the notification to the supplier
                    \Notification::send($supplier, new UserNotification($messages, 'New Price Inquiry', 'supplier_price_inquiry_entry', ['id' => $priceInquiry->id]));

                    // Send the email to the supplier
                    Mail::to($supplier->email)->send(new PriceInquiryNotification($messages, 'New Price Inquiry'));
                }

                foreach ($request->supplier_ids as $index => $supplier_id) {
                    foreach ($request->pcs as $pcsIndex => $pcsValue) {
                        foreach ($request->capacity as $capacityIndex => $capacityValue) {

                            $priceInquiry->inquirysuppliers()->create([
                                'user_id' => $supplier_id,
                                'quantity' => $pcsValue,
                                'capacity' => $capacityValue,
                            ]);
                        }

                    }
                }
            }

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
            $this->logEvent('Inquiry', 'Price Inquiry# ' . $priceInquiry->inquiry_number . ' created. ');
            return response()->json(['message' => 'Price inquiry submitted successfully'], 201);
        } catch (\Exception $e) {
            throw $e;
        }
    }
    public function quote(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'quoteIds' => 'required|exists:inquiry_suppliers,id',
        ]);

        InquirySupplier::where('price_inquiry_id', $id)
            ->update(['selected' => 0]);

        $inquirySupplier = InquirySupplier::where('price_inquiry_id', $id)
            ->whereIn('id', $request->input('quoteIds'))
            ->update(['selected' => 1]);

        if (!$inquirySupplier) {
            return response()->json(['error' => 'Failed to update quote'], 422);
        }

        $inquiry = PriceInquiry::find($id);

        if (!$inquiry) {
            return response()->json(['error' => 'Price inquiry not found'], 404);
        }

        $buyer = User::find($inquiry->buyer);

        if (!$buyer) {
            return response()->json(['error' => 'Buyer not found'], 404);
        }

        $message = "We have sent the quotation for your price inquiry #{$inquiry->inquiry_number}. Please review it. Contact us if you have any questions.";

        // Send the notification to the buyer
        \Notification::send($buyer, new UserNotification($message, 'Price Inquiry Quotation', 'buyer_price_inquiry_edit', ['id' => $inquiry->id]));

        // Send the email to the buyer
        //Mail::to($buyer->email)->send(new PriceInquiryNotification($message, 'Price Inquiry Quotation'));
        $this->logEvent('Inquiry', "Price Inquiry# {$inquiry->inquiry_number} supplier quoted. ");
        return response()->json(['message' => 'Quote selected successfully'], 201);
    }
    public function update_price_inquiry(Request $request, $id)
    {
        // dd($request->all(),$id);
        // Validate the incoming request data
        $validatedData = $request->validate([
            'supplier_ids' => 'array|exists:supplier_profiles,id',
            // 'buyer' => 'required|exists:users,id',
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


        if ($request->supplier_ids) {

            $inquiry_number = $validatedData['inquiry_number'];
            $messages = "A price inquiry with the number '$inquiry_number' has been added.";
            foreach ($request->supplier_ids as $supplierId) {
                // Get the supplier
                $supplier = User::find($supplierId);

                // Send the notification to the supplier
                \Notification::send($supplier, new UserNotification($messages, 'New Price Inquiry', 'supplier_price_inquiry_entry', ['id' => $id]));

                // Send the email to the supplier
                //Mail::to($supplier->email)->send(new PriceInquiryNotification($messages, 'New Price Inquiry'));
            }
        }

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

        // Original values
        $originalPcs = $priceInquiry->pcs;
        $originalCapacity = $priceInquiry->capacity;

        // Filter and update pcs
        $pcs = $request->input('pcs');
        $filteredPcs = array_filter($pcs, function ($value) {
            return $value !== null;
        });
        $priceInquiry->pcs = $filteredPcs;

        // Filter and update capacity
        $capacity = $request->input('capacity');
        $filteredCapacity = array_filter($capacity, function ($value) {
            return $value !== null && $value !== 'undefined';
        });
        $priceInquiry->capacity = $filteredCapacity;

        // Check if there are new values
        $hasNewPcs = !empty(array_diff($filteredPcs, $originalPcs));
        $hasNewCapacity = !empty(array_diff($filteredCapacity, $originalCapacity));
        // dd($hasNewPcs,$hasNewCapacity);
        // Auth::check() ? $priceInquiry->user_id = Auth::id() : '';
        $newSupplierIds = array_unique($request->supplier_ids);

        // Get existing supplier IDs from the database
        $existingSupplierIds = $priceInquiry->inquirysuppliers()->pluck('user_id')->toArray();

        // Check if there are differences between the two arrays
        $diff = array_diff($newSupplierIds, $existingSupplierIds);

        if ($hasNewPcs || $hasNewCapacity || !empty($diff)) {
            $priceInquiry->inquirysuppliers()->delete();

            foreach ($request->supplier_ids as $index => $supplier_id) {
                foreach ($request->pcs as $pcsIndex => $pcsValue) {
                    foreach ($request->capacity as $capacityIndex => $capacityValue) {

                        $priceInquiry->inquirysuppliers()->create([
                            'user_id' => $supplier_id,
                            'quantity' => $pcsValue,
                            'capacity' => $capacityValue,
                        ]);
                    }

                }
            }
        }

        // Update the fields with the validated data
        $priceInquiry->update($validatedData);
        $priceInquiry->save();
        $this->logEvent('Inquiry', 'Price Inquiry# ' . $priceInquiry->inquiry_number . ' updated. ');
        // Return a success response
        return response()->json(['message' => 'Price inquiry updated successfully'], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function product_group_get()
    {
        $prod = ProductGroup::select('id', 'group_name', 'hs_de', 'hs_cn')->get();
        // $formattedProducts = $prod->map(function ($product) {
        //     // Assuming the datetime fields are named 'created_at' and 'updated_at'
        //     $product->created_at = Carbon::parse($product->created_at)->toDateString(); // Adjust format as needed
        //     $product->updated_at = Carbon::parse($product->updated_at)->toDateString(); // Adjust format as needed
        //     return $product;
        // });

        // Return the formatted ProductGroup collection as JSON response
        return response()->json($prod, 200);
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
        return response()->json($prod, 200);
    }

    public function PriceDelete($id)
    {
        // dd($id);
        try {
            $priceInquiry = PriceInquiry::findOrFail($id);
            $priceInquiry->delete();
            $this->logEvent('Inquiry', 'Price Inquiry# ' . $priceInquiry->inquiry_number . ' deleted. ');
            return response()->json(['message' => 'Inquiry deleted successfully'], 200);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function product_group_destroy($id)
    {
        try {

            $group = ProductGroup::findOrFail($id);
            $this->logEvent('Group', 'Group ' . $group->group_name . ' has been deleted. ');
            $group->delete();
            return response()->json(['message' => 'Group deleted successfully'], 200);
        } catch (\Exception $e) {
            throw $e;
        }
    }
    public function product_group(Request $request)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'group_name' => 'required|string|max:255|unique:product_groups,group_name',
            'description' => 'required|string|max:255',
            'profit' => 'nullable',
            'amount' => 'nullable|numeric|max:99999999.99',
            'hs_de' => 'required|integer',
            'hs_cn' => 'required|integer',
            'additionalFields' => 'array', // Validate additional fields as an array
            'additionalFields.*.name' => 'required|string|max:255', // Validate each additional field's name
            'additionalFields.*.value' => 'required|string|max:255',
        ]);
        try {
            // Start a database transaction
            DB::beginTransaction();
            $product = new ProductGroup();
            $product->group_name = $validatedData['group_name'];
            $product->description = $validatedData['description'];
            $product->profit = $validatedData['profit'];
            $product->amount = $validatedData['amount'];
            $product->hs_de = $validatedData['hs_de'];
            $product->hs_cn = $validatedData['hs_cn'];
            $product->save();

            if (isset($validatedData['additionalFields'])) {
                foreach ($validatedData['additionalFields'] as $field) {
                    // dd($field);
                    $product->additionalFields()->create([
                        'name' => $field['name'],
                        'value' => $field['value']
                    ]);
                }
            }

            $this->logEvent("Group", "New Group '$product->group_name' has been created.");
            // Notification
            $admins = User::role(['Admin', 'Internal'])->get();
            $productName = e($validatedData['group_name']);
            $message = "Good News! A new product group with the name '$productName' has been added.";

            \Notification::send($admins, new UserNotification($message, 'New Product Group', 'product_group_update', ['id' => $product->id]));
            DB::commit();
            return response()->json(['message' => 'Product created successfully']);
        } catch (\Exception $e) {
            // Rollback the transaction if an error occurs
            DB::rollBack();

            // Log the error for debugging purposes
            \Log::error($e->getMessage());

            // Return an error response
            return response()->json(['message' => 'An error occurred while saving the product group.' . $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function updprod(Request $request, $id)
    {
        // dd($request->all(), $id);
        try {
            $validatedData = $request->validate([
                'article' => 'required|max:255',
                'standart_packaging' => 'required|max:255',
                'status' => 'required',
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'group' => 'required|integer|max:255',
                'cargo' => 'nullable|string|max:255',
                'cargo_place' => 'nullable',
                'color' => 'required',
                'material' => 'required',
                'accessory' => 'required',
                'size' => 'nullable|string|max:255',
                'weight' => 'nullable|string|max:255',
                'specification' => 'nullable|string',
                'memory' => 'nullable|string|max:255',
                'feature' => 'nullable|string|max:255',
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
                'quoteExpiredDate' => 'required|date',
                'train_safety_expiry' => 'nullable|date',
                'certificate' => 'nullable|string|max:255',
                'printing_method' => 'nullable|string|max:255',
                'unit_packaging_paper' => 'nullable|integer',
                'unit_packaging_plastic' => 'nullable|integer',
                'unit_packaging_metal' => 'nullable|integer',
                'unit_packaging_others' => 'nullable|integer',
                'packaging_material' => 'nullable|string|max:255',
                'packaging_weight' => 'nullable|integer',

            ]);
            $print_areas = $request->validate([
                'print_areas' => 'required',
                'print_areas.*.position' => 'required|string|max:255',
                'print_areas.*.size' => 'required|string|max:255',
                'print_areas.*.method' => 'required|string|max:255',

            ]);
            DB::beginTransaction();
            $product = Products::findOrFail($id);
            if ($validatedData['status'] !== $product->status) {
                $this->logEvent('Product', 'Article Number ' . $product->article . ' status changed from ' . $product->status . 'to ' . $validatedData['status']);
            }
            $product->update($validatedData);
            $product->printAreas()->delete();

            $print_areas = json_decode($request->input('print_areas'), true);

            foreach ($print_areas as $printAreaData) {
                $product->printAreas()->create($printAreaData);
            }
            // Save images
            if ($request->file('newimages')) {
                foreach ($request->file('newimages') as $image) {
                    $fileName = \Str::random(5) . $image->getClientOriginalName();
                    $path = $image->storeAs('images', $fileName, 'public');
                    // $path = $image->store('images', 'public');
                    // Attach image to the product
                    $product->images()->create(['path' => $path, 'name' => $image->getClientOriginalName()]);
                }
            }
            $fileFields = [
                ['field' => 'safety_sheet', 'path' => 'safety_sheets', 'key' => 'safety_sheet'],
                ['field' => 'manual', 'path' => 'manuals', 'key' => 'manual'],
                ['field' => 'product_label', 'path' => 'product_labels', 'key' => 'product_label'],
                ['field' => 'packaging_label', 'path' => 'packaging_labels', 'key' => 'packaging_label'],
            ];

            // Loop through the file fields
            foreach ($fileFields as $fileField) {
                $file = $request->file($fileField['field']);

                // Check if a new file is uploaded
                if ($file) {
                    // Delete the old file from storage if it exists
                    $existingFile = json_decode($product->{$fileField['key']}, true);
                    // dd($existingFile['path']);
                    // Delete the old file from storage if it exists
                    if ($existingFile && isset($existingFile['path']) && Storage::disk('public')->exists($existingFile['path'])) {
                        Storage::disk('public')->delete($existingFile['path']);
                    }

                    // Store the new file
                    $path = $file->store($fileField['path'], 'public');
                    $originalName = $file->getClientOriginalName();

                    // Attach new file paths to the product
                    $product->{$fileField['key']} = ['path' => $path, 'name' => $originalName];
                }
            }

            // Save the product
            $product->save();

            // Notification
            // $admins = User::role(['Admin', 'Internal', 'Buyer'])->get();
            // $productName = e($validatedData['name']);
            // $message = "Good News! A new product with the name '$productName' has been added.";

            // \Notification::send($admins, new UserNotification($message, 'New Product', null));

            // $buyers = User::role('Buyer')->pluck('email');
            // // dd($buyers);
            // foreach ($buyers as $Buyer) {
            //     \Mail::to($Buyer)->send(new ProductNotification($validatedData, 'create'));
            // }

            DB::commit();

            return response()->json(['message' => 'Product saved successfully'], 200);
        } catch (\Exception $e) {

            DB::rollBack();
            throw $e;
        }
    }
    public function deleteimage($id)
    {
        $image = ProductImages::findOrFail($id);
        $imagePath = 'public/' . $image->path;
        if (Storage::exists($imagePath)) {
            Storage::delete($imagePath);
        }

        // Step 3: Delete the image record from the database
        $image->delete();

        // Return a response, for example:
        return response()->json(['success' => 'Image deleted successfully.']);

    }
    public function addprod(Request $request)
    {
        // In your controller's validation method
        try {
            $validatedData = $request->validate([
                'article' => 'required|max:255',
                'standart_packaging' => 'required|max:255',
                'status' => 'required',
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'group' => 'nullable|integer|max:255',
                'cargo' => 'nullable|string|max:255',
                'cargo_place' => 'nullable',
                'color' => 'required',
                'material' => 'required',
                'accessory' => 'required',
                'size' => 'nullable|string|max:255',
                'weight' => 'nullable|string|max:255',
                'specification' => 'nullable|string',
                'memory' => 'nullable|string|max:255',
                'feature' => 'nullable|string|max:255',
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
                'quoteExpiredDate' => 'required|date',
                'train_safety_expiry' => 'nullable|date',
                'certificate' => 'nullable|string|max:255',
                'printing_method' => 'nullable|string|max:255',
                'unit_packaging_paper' => 'nullable|integer',
                'unit_packaging_plastic' => 'nullable|integer',
                'unit_packaging_metal' => 'nullable|integer',
                'unit_packaging_others' => 'nullable|integer',
                'packaging_material' => 'nullable|string|max:255',
                'packaging_weight' => 'nullable|integer',

            ]);
            $print_areas = $request->validate([
                'print_areas' => 'required',
                'print_areas.*.position' => 'required|string|max:255',
                'print_areas.*.size' => 'required|string|max:255',
                'print_areas.*.method' => 'required|string|max:255',

            ]);
            // dd($request->print_areas);

            DB::beginTransaction();
            $product = Products::create($validatedData);
            $print_areas = json_decode($request->input('print_areas'), true);

            foreach ($print_areas as $printAreaData) {
                $product->printAreas()->create($printAreaData);
            }
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
            // $safetySheetPath = $request->file('safety_sheet') ? $request->file('safety_sheet')->store('safety_sheets', 'public') : null;
            // $manualPath = $request->file('manual') ? $request->file('manual')->store('manuals', 'public') : null;
            // $productLabelPath = $request->file('product_label') ? $request->file('product_label')->store('product_labels', 'public') : null;
            // $packagingLabelPath = $request->file('packaging_label') ? $request->file('packaging_label')->store('packaging_labels', 'public') : null;

            // Define an array of file fields
            $fileFields = [
                ['field' => 'safety_sheet', 'path' => 'safety_sheets', 'key' => 'safety_sheet'],
                ['field' => 'manual', 'path' => 'manuals', 'key' => 'manual'],
                ['field' => 'product_label', 'path' => 'product_labels', 'key' => 'product_label'],
                ['field' => 'packaging_label', 'path' => 'packaging_labels', 'key' => 'packaging_label'],
            ];

            // Loop through the file fields
            foreach ($fileFields as $fileField) {
                $file = $request->file($fileField['field']);
                $path = $file ? $file->store($fileField['path'], 'public') : null;
                $originalName = $file ? $file->getClientOriginalName() : null;

                // Attach file paths to the product
                $product->{$fileField['key']} = ['path' => $path, 'name' => $originalName];
            }

            // Attach user_id to the product
            $product->user_id = auth()->user()->id ?? '';

            // Save the product
            $product->save();

            // Notification
            $admins = User::role(['Admin', 'Internal', 'Buyer'])->get();
            $productName = e($validatedData['name']);
            $message = "Good News! A new product with the name '$productName' has been added.";

            \Notification::send($admins, new UserNotification($message, 'New Product', null));

            $buyers = User::role('Buyer')->pluck('email');
            // dd($buyers);
            foreach ($buyers as $Buyer) {
                Mail::to($Buyer)->send(new ProductNotification($validatedData, 'create'));
            }
            $this->logEvent('Product', 'Article Number ' . $product->article . ' has been added. ');
            DB::commit();

            return response()->json(['message' => 'Product saved successfully'], 201);
        } catch (\Exception $e) {

            DB::rollBack();
            throw $e;
        }

    }

    /**
     * Display the specified resource.
     */
    public function price_inquiry_get()
    {
        $prod = PriceInquiry::orderby('created_at', 'desc')->with('product_group','inquirysuppliers.user', 'inquirysuppliers.supplierremarks')->get();
        if ($prod->isNotEmpty()) {
            $prod = $prod->map(function ($item) {
                // Group inquirysuppliers by user ID, handle potential null values
                $item->supplierData = $item->inquirysuppliers->groupBy(function ($supplier) {
                    return optional($supplier->user)->supplier_id;
                });
                return $item;
            });
        }
        return response()->json($prod, 200);
    }
    public function show(string $id)
    {
        $prod['price'] = PriceInquiry::where('id', $id)->with('inquirysuppliers.user', 'inquirysuppliers.supplierremarks')->first();
        if ($prod) {
            // Group inquirysuppliers by user ID
            $prod['users'] = $prod['price']->inquirysuppliers->groupBy(function ($supplier) {
                return $supplier->user->supplier_id;
            });
        }
        return response()->json($prod, 200);
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
            $this->logEvent('Product', 'Article Number ' . $user->article . ' has been deleted. ');
            $user->delete();
            return response()->json(['message' => 'Product deleted successfully'], 200);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
