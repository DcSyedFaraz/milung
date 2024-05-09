<?php

namespace App\Http\Controllers;

use App\Models\ProductGroup;
use App\Models\Products;
use App\Models\ShipmentOrder;
use App\Models\SupplierProfile;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
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
        // $admin = auth()->user();
        // $permission = Permission::create(['name' => 'edit articles', 'guard_name' => 'web']);

        // $admin->givePermissionTo($permission);
        // dd($responseData);
        return response()->json($responseData, 200);
    }
    public function products()
    {
        $products = Products::select('article', 'name', 'id', 'description', 'group', 'status')->with([
            'product_group' => function ($query) {
                $query->select('id', 'group_name');
            }
        ])->orderby('created_at', 'desc')->get();
        return response()->json($products, 200);
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

        return response()->json($responseData, 200);
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

        return response()->json($users, 200);
    }
    public function supplierOrder()
    {
        $users = User::withRole('Supplier')->select('id', 'userid')->get();

        return response()->json($users, 200);
    }
    public function buyerOrder()
    {
        $users = User::withRole('Buyer')->select('id', 'userid')->get();

        return response()->json($users, 200);
    }
    public function buyerFinance()
    {
        $data['users'] = User::withRole('Buyer')->select('id', 'userid')->get();

        $data['sales'] = ShipmentOrder::select('shipment_orders.buyerid', 'users.userid', \DB::raw('SUM(information.totalpayable) as total_payable_per_buyer'))
            ->join('information', 'shipment_orders.id', '=', 'information.shipment_order_id')
            ->join('users', 'shipment_orders.buyerid', '=', 'users.id')
            ->groupBy('shipment_orders.buyerid', 'users.userid')
            ->having(\DB::raw('SUM(information.totalpayable)'), '>', 0)
            ->get();

        $data['remaining'] = ShipmentOrder::select('shipment_orders.buyerid', 'users.userid', \DB::raw('SUM(settle_amounts.outstanding_amount) as total_outstanding_per_buyer'))
            ->join('settle_amounts', 'shipment_orders.id', '=', 'settle_amounts.shipment_order_id')
            ->join('users', 'shipment_orders.buyerid', '=', 'users.id')
            ->groupBy('shipment_orders.buyerid', 'users.userid')
            ->having(\DB::raw('SUM(settle_amounts.outstanding_amount)'), '>', 0)
            ->get();

        return response()->json($data, 200);
    }
    public function addUser(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'userid' => 'required|unique:users,userid|regex:/^[^\s]+$/',
            'email' => 'required|string|email|max:255|unique:users',
            'status' => 'required|string|in:active,inactive',
            'roles' => 'required|string|in:Admin,Buyer,Supplier,Internal',
            'password' => 'required|string|min:8',
            'permissions' => 'nullable|array',
            'contact_person' => 'nullable|string',
        ]);
        // dd($request->all());
        try {
            $user = new User($validatedData);
            $user->password = Hash::make($request->password);
            $user->save();
            $user->assignRole($validatedData['roles']);

            if ($validatedData['roles'] == 'Admin') {
                $permissions = Permission::all();
            } else {
                $permissions = $request->permissions;
            }

            $user->syncPermissions($permissions);

            return response()->json(['message' => 'Successfully created user!', 'data' => $permissions], 201);
        } catch (\Exception $e) {
            // Return error response if an exception occurs
            return response()->json(['message' => 'Failed to save data', 'error' => $e->getMessage()], 500);
        }
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
        return response()->json($responseData, 200);
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
        // dd($data);
        $validator = Validator::make($data, [
            'status' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:8',
            'permissions' => 'nullable|array',
            'contact_person' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();

            // Return JSON response with errors
            return response()->json(['errors' => $errors], 422);
        }


        try {

            $user = User::find($id);

            if (!$user) {
                return response()->json([
                    'message' => 'User not found',
                ], 404);
            }

            $user->update($data);

            if ($request->password) {
                $user->password = Hash::make($request->password);
                $user->save();
            }
            // $role = $data['roles'];

            // if ($role != implode(',', $user->getRoleNames()->toArray())) {
            //     $user->syncRoles($role);
            // }

            $user->syncPermissions($data['permissions']);

            return response()->json([
                'message' => 'User updated successfully',
                'user' => $user,
            ], 200);
        } catch (\Exception $e) {
            // Return error response if an exception occurs
            return response()->json(['message' => 'Failed to save data', 'error' => $e->getMessage()], 500);
        }
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
