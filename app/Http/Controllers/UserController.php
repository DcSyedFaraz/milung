<?php

namespace App\Http\Controllers;

use App\Models\ProductGroup;
use App\Models\Products;
use App\Models\SupplierProfile;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function login(Request $request)
    {
        // return response()->json(['token' => $request->all()]);
        $credentials = $request->only('email', 'password');
        // return $credentials;
        if (Auth::attempt($credentials)) {

            $user = auth()->user();
            $roles = $user->getRoleNames()->toArray();
            // return $roles[0];
            $token = $user->createToken('authToken', [$roles[0]])->plainTextToken;

            return response()->json(['token' => $token, 'success' => true, 'role' => $user->getRoleNames()->first(),], 200);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function users()
    {
        $users = User::where('email', '<>', 'admin@gmail.com')->get();
        $responseData = [];

        foreach ($users as $user) {
            $userData = [
                'id' => $user->id,
                'userid' => $user->userid,
                'name' => $user->name,
                'buyer_id' => $user->buyer_id,
                'email' => $user->email,
                'status' => $user->status,
                'roles' => $user->getRoleNames()->toArray(),
                'permissions' => $user->getPermissionNames()->toArray(),
            ];

            $responseData[] = $userData;
        }
        // dd($responseData);
        return response()->json($responseData, JsonResponse::HTTP_OK);
    }
    public function products()
    {
        $products = Products::select('article', 'name', 'id', 'description', 'group', 'status')->with([
            'product_group' => function ($query) {
                $query->select('id', 'group_name');
            }
        ])->get();
        return response()->json($products, JsonResponse::HTTP_OK);
    }
    public function supplier()
    {
        $users = User::withRole('Supplier')->with('supplierProfile')->get();

        $responseData = [];
        foreach ($users as $user) {
            $supplierProfile = $user->supplierProfile;
            if ($supplierProfile) {
                $group = $supplierProfile->group;
                $groupNames = ProductGroup::whereIn('id', $group)->pluck('group_name')->toArray();
                $user->supplierProfile->group_names = $groupNames;
            }
            $responseData[] = $user;
        }

        return response()->json($responseData, JsonResponse::HTTP_OK);
    }

    public function buyers(Request $request)
    {
        // dd($request);


        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'userid' => 'required|unique:users,userid',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }


        $user = User::create([
            'userid' => $request->userid,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('12345678'),
            // Add any other user-related fields
        ]);

        // Store buyer profile data
        $user->buyerProfile()->create([
            'address' => $request->address,
            'website' => $request->website,
            'office_phone' => $request->officePhone,
            'contact' => $request->contact,
            'buyer_description' => $request->buyerDescription,
            'group' => $request->group,
            // 'sec_group' => $request->Secgroup,
        ]);

        // Assign the 'supplier' role (or any other role) using Spatie permissions
        $user->assignRole('Buyer');
        return response()->json(['message' => 'Successfully created user!'], 201);
    }
    public function suppliers(Request $request)
    {
        // dd($request);
        // return response()->json(['message' => 'Successfully created user!'], 201);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'userid' => 'required|unique:users,userid',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }


        $user = User::create([
            'userid' => $request->userid,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('12345678'),
            // Add any other user-related fields
        ]);

        // Store buyer profile data
        $user->supplierProfile()->create([
            'address' => $request->address,
            'website' => $request->website,
            'office_phone' => $request->officePhone,
            'contact' => $request->contact,
            'buyer_description' => $request->buyerDescription,
            'group' => $request->group,
            'sec_group' => $request->Secgroup,
        ]);

        // Assign the 'supplier' role (or any other role) using Spatie permissions
        $user->assignRole('Supplier');
        return response()->json(['message' => 'Successfully created user!'], 201);
    }
    public function buyer()
    {
        $users = User::withRole('Buyer')->with('buyerProfile')->get();


        // dd($responseData);
        return response()->json($users, JsonResponse::HTTP_OK);
    }
    public function addUser(Request $request)
    {
        // dd($request);
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'userid' => 'required|unique:users,userid',
            'email' => 'required|string|email|max:255|unique:users',
            'status' => 'required|string|in:active,inactive',
            'roles' => 'required|string|in:Admin,Buyer,Supplier',
            'password' => 'required|string|min:8',
        ]);

        $user = new User($validatedData);
        $user->password = Hash::make($request->password);
        $user->save();
        $user->assignRole($validatedData['roles']);
        return response()->json(['message' => 'Successfully created user!'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function usersEdit($id)
    {
        $user = User::find($id);
        // dd($user);

        $userData = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'status' => $user->status,
            'buyer_id' => $user->buyer_id,
            'roles' => $user->getRoleNames()->toArray(),
        ];

        $responseData = $userData;
        // // dd($responseData);
        return response()->json($responseData, JsonResponse::HTTP_OK);
    }
    public function supplier_profiles($id)
    {
        // dd($id);
        // Typecast $id to ensure it's of the correct type
        $id = (int) $id;

        // Assuming $id is an integer
        $idJson = json_encode([$id]); // Convert integer to JSON array
        $supplierProfiles = SupplierProfile::whereRaw("JSON_CONTAINS(`group`, ?)", [$idJson])
            ->with('user:id,name')
            ->get();


        // Iterate through $supplierProfiles to create the desired response structure
        $data = $supplierProfiles->map(function ($profile) {
            return [
                'id' => $profile->user->id,
                'name' => $profile->user->name
            ];
        });

        // Assuming you want to return JSON response with user id and name
        return response()->json($data);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = $request->updateuser;
        $validator = Validator::make($data, [
            'status' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            // 'buyer_id' => 'required',
            // 'roles' => ['required', Rule::in(['Admin', 'Buyer', 'Supplier'])],
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();

            // Return JSON response with errors
            return response()->json(['errors' => $errors], 422);
        }


        // dd($data['permissions'], $id);

        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }

        $user->update([
            'status' => $data['status'],
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

        // $role = $data['roles'];

        // if ($role != implode(',', $user->getRoleNames()->toArray())) {
        //     $user->syncRoles($role);
        // }
        $user->syncPermissions($data['permissions']);

        return response()->json([
            'message' => 'User updated successfully',
            'user' => $user,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delUser(string $id)
    {
        // dd($id);
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return response()->json(['message' => 'User deleted successfully'], 200);
        } catch (\Exception $e) {
            throw $e;
        }
    }

}
