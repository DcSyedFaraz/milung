<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessUserNotifications;
use App\Mail\OTPMail;
use App\Mail\PasswordResetRequested;
use App\Mail\AccountCreated;
use App\Mail\PriceInquiryNotification;
use App\Models\BuyerProfile;
use App\Models\EventLog;
use App\Models\Order;
use App\Models\ProductGroup;
use App\Models\Products;
use App\Models\ShipmentOrder;
use App\Models\SupplierProfile;
use App\Models\User;
use App\Notifications\UserNotification;
use Carbon\Carbon;
use DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Mail;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{


    public function parentid(Request $request)
    {
        // dd($request->all());
        $role = $request->input('role');
        if ($role == 'Supplier') {
            $data = SupplierProfile::select('id', 'supplier_id as userid', 'name')->get();
        } else {
            $data = BuyerProfile::select('id', 'buyer_id as userid', 'name')->get();
        }

        return response()->json($data);
    }
    public function events(Request $request)
    {
        $filterValue = $request->input('filter');
        // dd($filterValue);
        $event = EventLog::when($filterValue, function ($query) use ($filterValue) {
            $query->where('event', $filterValue);
        })->orderBy('created_at', 'desc')->with('user')->get();

        return response()->json($event);
    }
    public function index()
    {
        // $admin = User::role(['Admin', 'Internal'])->get();
        //     $message = "created new noti ";
        //     Notification::send($admin, new UserNotification($message,'Post'));
        // broadcast(new UserNotification($message,'Post'))->toOthers();
        $notifications['msg'] = auth()->user()->unreadnotifications()->latest()->take(3)->get();
        $notifications['count'] = auth()->user()->unreadnotifications()->count();

        return response()->json($notifications);
    }
    public function userDetails()
    {
        $user = auth()->user();

        return response()->json($user);
    }
    public function profile(Request $request)
    {
        $id = Auth::id();
        $rules = [
            'name' => 'required|string|max:255',
            // 'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|same:confirmPassword',
        ];

        $validatedData = $request->validate($rules);

        $user = User::findOrFail($id);
        $user->name = $validatedData['name'];
        // $user->email = $validatedData['email'];

        if (isset($validatedData['password'])) {

            if (Hash::check($validatedData['password'], $user->password)) {
                return response()->json(['message' => 'The new password cannot be the same as the current password.'], 400);
            }

            $user->password = Hash::make($validatedData['password']);
            $user->password_updated_at = now();
        }
        $user->save();

        return response()->json(['message' => 'User updated successfully'], 200);
    }
    public function all_notifications()
    {
        // $admin = User::role(['Admin', 'Internal'])->get();
        //     $message = "created new noti ";
        //     Notification::send($admin, new UserNotification($message,'Post'));
        // broadcast(new UserNotification($message,'Post'))->toOthers();
        $notifications['msg'] = auth()->user()->notifications()->latest()->get();
        // $notifications['count'] = auth()->user()->unreadnotifications()->count();

        return response()->json($notifications);
    }

    public function markAsRead($id)
    {
        auth()->user()->notifications->where('id', $id)->markasread();

        return response()->json(['message' => 'Notification marked as read.']);
    }
    /**
     * Display a listing of the resource.
     */
    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        // Check if the provided password matches the OTP column value for the user
        $user = User::where('email', $email)->first();

        if ($user) {

            if ($user->status == 'inactive') {
                return response()->json([
                    'inactive' => true,
                    'message' => 'The user is inactive. Please contact support for further assistance.'
                ], 200);
            }

            $oneMonthAgo = Carbon::now()->subMonth();
            $otpLoginSuccess = false;
            $message = '';

            if ($user->otp === $password) {
                $otpLoginSuccess = true;
                $message = 'OTP login successful';
            } elseif (Carbon::parse($user->password_updated_at)->lessThanOrEqualTo($oneMonthAgo)) {
                $otpLoginSuccess = true;
                $message = 'Password not changed in the last month. Please update your password.';
            }

            if ($otpLoginSuccess) {
                // OTP login successful, set flag and save email in session
                $request->session()->put('otp_login_email', $email);
                return response()->json(['otp_login' => true, 'message' => $message], 200);
            }
        }

        // If OTP login failed, attempt regular password authentication
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            $user = auth()->user();
            $roles = $user->getRoleNames()->toArray();
            $token = $user->createToken('authToken', [$roles[0]])->plainTextToken;
            return response()->json(['token' => $token, 'success' => true, 'role' => $user->getRoleNames()->first()], 200);
        }

        // Authentication failed
        if ($user) {
            $user->increment('login_attempts');

            if ($user->login_attempts >= 5) {
                $user->status = 'inactive';
                $user->login_attempts = 0;
                $user->save();

                $message = "User with ID {$user->userid} has been set to inactive due to multiple failed login attempts.";
                $admins = User::role('Admin')->pluck('email');
                foreach ($admins as $admin) {
                    \Mail::to($admin)->send(new PriceInquiryNotification($message, 'User Inactive Notification'));
                }

                return response()->json([
                    'inactive' => true,
                    'message' => 'The user is now inactive due to multiple failed login attempts. Please contact admin.'
                ], 200);
            }
        }

        // Authentication failed
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    public function passChange(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|same:confirmPassword'
        ]);

        // dd($request->session()->get('otp_login_email'),$request->all());
        if ($request->session()->get('otp_login_email')) {

            $user = User::where('email', $request->session()->get('otp_login_email'))->first();

            if (Hash::check($request->password, $user->password)) {
                return response()->json(['message' => 'The new password cannot be the same as the current password.'], 400);
            }
            $user->password = Hash::make($request->password);
            $user->otp = null;
            $user->password_updated_at = now();
            $user->save();
            return response()->json(['message' => 'Password reset successfully!'], 200);
        } else {

            return response()->json(['message' => 'Please contact the admin to proceed with the password change.']);
        }
    }
    public function forgotPass(Request $request)
    {
        $credentials = $request->only('email');

        // Assuming $user contains the user record corresponding to the provided email
        $user = User::where('email', $credentials['email'])->first();

        // Check if user exists
        if ($user) {
            // Send email notification to admin

            $admins = User::role('Admin')->get();

            foreach ($admins as $admin) {
                Mail::to($admin->email)->send(new PasswordResetRequested($user));
            }

            $message = "Hello! User with the ID: {$user->userid} has requested a password reset.";
            $route = 'user';

            Notification::send($admins, new UserNotification($message, 'Forgot Password', $route));

            Notification::send($user, new UserNotification('Password Reset Requested!', 'Forgot Password', null));

            return response()->json(['message' => 'Password reset request sent successfully'], 200);
        }

        return response()->json(['message' => 'User not found'], 404);
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
                'contact_number' => $user->contact_number,
                'contact_person' => $user->contact_person,
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
    public function userGet($id)
    {
        $user = User::where('id', $id)->first();
        $responseData = [];

        $userData = [
            'id' => $user->id,
            'userid' => $user->userid,
            'name' => $user->name,
            'contact_number' => $user->contact_number,
            'contact_person' => $user->contact_person,
            'email' => $user->email,
            'status' => $user->status,
            'roles' => $user->getRoleNames()->toArray(),
            'permissions' => $user->getPermissionNames()->toArray(),
        ];

        // $admin = auth()->user();
        // $permission = Permission::create(['name' => 'edit articles', 'guard_name' => 'web']);

        // $admin->givePermissionTo($permission);
        // dd($responseData);
        return response()->json($userData, 200);
    }
    public function products()
    {
        $products = Products::select('article', 'name', 'id', 'description', 'group', 'status')->with(['images',
            'product_group' => function ($query) {
                $query->select('id', 'group_name');
            }
        ])->orderby('created_at', 'desc')->get();
        // dd($products);
        return response()->json($products, 200);
    }
    public function supplier()
    {
        $users = SupplierProfile::with('person')->get();

        $responseData = [];
        foreach ($users as $user) {
            $group = $user->group;
            $groupNames = ProductGroup::whereIn('id', $group)->pluck('group_name')->toArray();
            $user->group_names = $groupNames;

            $responseData[] = $user;
        }

        return response()->json($responseData, 200);
    }

    public function buyersUpdate(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'userid' => 'required||regex:/^[^\s]+$/|unique:users,userid,' . $id,
            'group' => 'array',
            'group.*' => 'integer|exists:product_groups,id',
            'status' => 'required|string|in:active,inactive',
            'contact_person' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::findOrFail($id);

        if ($request->status != $user->status) {
            $this->logEvent('Buyer', 'Buyer ID ' . $user->userid . ' status has been changed to ' . $request->status . '.');
        }
        $user->update([
            'userid' => $request->userid,
            'name' => $request->name,
            'email' => $request->email,
            'status' => $request->status,
            'contact_person' => $request->contact_person,
            // Add any other user-related fields
        ]);

        $user->buyerProfile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'address' => $request->address,
                'website' => $request->website,
                'office_phone' => $request->officePhone,
                'buyer_description' => $request->buyerDescription,
                'group' => $request->group,
            ]
        );

        return response()->json(['message' => 'Successfully updated user!'], 200);
    }

    public function buyers(Request $request)
    {
        // dd($request->all());


        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'buyer_id' => 'required|unique:buyer_profiles,buyer_id|regex:/^[^\s]+$/',
            'status' => 'required|string|in:active,inactive',
            'address' => 'required|string',
            'website' => 'required|string',
            'officePhone' => 'required|string',
            'buyerDescription' => 'required|string',
            'group' => 'required|array',
            'group.*' => 'integer|exists:product_groups,id',

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        try {
            DB::beginTransaction();


            // Store buyer profile data
            $user = BuyerProfile::create([
                'buyer_id' => $request->buyer_id,
                'name' => $request->name,
                'address' => $request->address,
                'website' => $request->website,
                'office_phone' => $request->officePhone,
                'buyer_description' => $request->buyerDescription,
                'group' => $request->group,
                // 'sec_group' => $request->Secgroup,
            ]);

            // ProcessUserNotifications::dispatch($user, $request->otp);
            $admin = User::role(['Admin', 'Internal'])->get();
            //Mail::to($user->email)->send(new AccountCreated($user, $request->otp));
            $message = "Hello!\n\nA new buyer has been successfully added to the system.\n\Buyer ID: {$user->buyer_id}\n\nThank you!";


            Notification::send($admin, new UserNotification($message, 'New Buyer', 'editbuyer', ['id' => $user->id]));

            $this->logEvent("Buyer", "User ID '$user->buyer_id' has been created.");
            DB::commit();
            return response()->json(['message' => 'Successfully created user!'], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            // throw $e;
            // Return error response if an exception occurs
            return response()->json(['message' => 'Failed to save data', 'error' => $e->getMessage()], 500);
        }
    }
    public function suppliers(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'status' => 'required|string|in:active,inactive',
            'supplier_id' => 'required|unique:supplier_profiles,supplier_id|regex:/^[^\s]+$/',
            'address' => 'required|string|max:255',
            'website' => 'required',
            'officePhone' => 'required|string|max:255',
            'supplierDescription' => 'required|string|max:255',
            'group' => 'required|array',
            'group.*' => 'integer|exists:product_groups,id',
            'Secgroup' => 'required|array',
            'Secgroup.*' => 'integer',
            'company_header' => 'required|string|max:255',
            'bank' => 'required|string|max:255',
            'bank_address' => 'required',
            'swift_code' => 'required|string|max:255',
            'chips_no' => 'required',
            'beneficiary_name' => 'required|string|max:255',
            'account_no' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }



        // Store buyer profile data
        $user = SupplierProfile::create([
            'name' => $request->name,
            'supplier_id' => $request->supplier_id,
            'status' => $request->status,
            'address' => $request->address,
            'website' => $request->website,
            'office_phone' => $request->officePhone,
            'supplier_description' => $request->supplierDescription,
            'group' => $request->group,
            'sec_group' => $request->Secgroup,
            'company_header' => $request->company_header,
            'bank' => $request->bank,
            'bank_address' => $request->bank_address,
            'swift_code' => $request->swift_code,
            'chips_no' => $request->chips_no,
            'beneficiary_name' => $request->beneficiary_name,
            'account_no' => $request->account_no,
        ]);

        // Assign the 'Supplier' role using Spatie permissions
        // $user->assignRole('Supplier');

        $admin = User::role(['Admin', 'Internal'])->get();
        //Mail::to($user->email)->send(new AccountCreated($user, $request->otp));
        $message = "Hello!\n\nA new supplier has been successfully added to the system.\n\nSupplier ID: {$user->supplier_id}\n\nThank you!";

        Notification::send($admin, new UserNotification($message, 'New Supplier', 'editsupplier', ['id' => $user->id]));

        $this->logEvent("Supplier", "Supplier ID '$user->supplier_id' has been created.");

        return response()->json(['message' => 'Successfully created supplier!'], 201);
    }

    public function buyer()
    {
        $users = BuyerProfile::with('person')->get();

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
        if ($request->parent_userid) {
            $newuserid = $request->parent_userid . '-' . $request->userid;
            $request->merge(['userid' => $newuserid]);
        }
        // dd($request->all());

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'userid' => 'required|unique:users,userid|regex:/^[^\s]+$/',
            'email' => 'required|string|email|max:255|unique:users',
            'status' => 'required|string|in:active,inactive',
            'roles' => 'required|string|in:Admin,Buyer,Supplier,Internal',
            'otp' => 'required|string|min:8|regex:/^[^\s]+$/',
            'permissions' => 'nullable|array',
            'contact_person' => 'nullable|string',
            'parent_id' => 'nullable|integer',
            'contact_number' => 'nullable|string',
        ]);

        // dd($validatedData['userid']);
        try {

            $user = new User($validatedData);
            $user->password = Hash::make($validatedData['otp']);

            if ($validatedData['roles'] == 'Supplier') {
                $user->supplier_id = $validatedData['parent_id'];
            } else if ($validatedData['roles'] == 'Buyer') {
                $user->buyer_id = $validatedData['parent_id'];
            }

            $user->save();

            $user->assignRole($validatedData['roles']);

            if ($validatedData['roles'] == 'Admin') {
                $permissions = Permission::all();
            } else {
                $permissions = $request->permissions;
            }

            $user->syncPermissions($permissions);

            $admin = User::role(['Admin', 'Internal'])->get();

            if ($validatedData['roles'] == 'Supplier') {

                Mail::to($user->email)->send(new AccountCreated($user, $validatedData['otp']));
                $message = "Hello!\n\nA new supplier has been successfully added to the system.\n\nSupplier ID: {$user->userid}\n\nThank you!";

                Notification::send($admin, new UserNotification($message, 'New Supplier', 'editsupplier', ['id' => $user->id]));
            } elseif ($validatedData['roles'] == 'Buyer') {

                Mail::to($user->email)->send(new AccountCreated($user, $validatedData['otp']));
                $message = "Hello!\n\nA new buyer has been successfully added to the system.\n\Buyer ID: {$user->userid}\n\nThank you!";

                Notification::send($admin, new UserNotification($message, 'New Buyer', 'editbuyer', ['id' => $user->id]));

            }
            $role = $validatedData['roles'];

            $this->logEvent("$role", "User ID '$user->userid' has been created.");

            return response()->json(['message' => 'Successfully created user!', 'data' => $permissions], 200);
        } catch (\Exception $e) {
            // Return error response if an exception occurs
            return response()->json(['message' => 'Failed to save data', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function buyersShow($id)
    {
        // $buyer = User::with('buyerProfile')->findOrFail($id);
        $buyer['user'] = BuyerProfile::where('id', $id)->with('person')->first();
        $buyer['orders'] = Order::where('buyer', $id)->select('id', 'sellingprice', 'article', 'orderdate', 'quantity_unit')->take(3)->orderby('created_at', 'desc')->get();

        return response()->json($buyer);
    }
    public function suppliersShow($id)
    {
        $supplier['user'] = SupplierProfile::where('id', $id)->with('person')->first();
        $supplier['orders'] = Order::where('supplier', $id)->select('id', 'buyingprice', 'article', 'orderdate', 'quantity_unit')->take(3)->orderby('created_at', 'desc')->get();
        return response()->json($supplier);
    }
    public function suppliersUpdate(Request $request, $userid)
    {
        // dd($request->all());
        // Fetch the existing user
        $user = SupplierProfile::where('id', $userid)->firstOrFail();

        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            // 'email' => 'required|email|unique:users,email,' . $user->id,
            // 'userid' => 'required|unique:users,userid,' . $user->id,
            'address' => 'required|string|max:255',
            'website' => 'required',
            'status' => 'required|string|in:active,inactive',
            'contact' => 'required|string|max:255',
            'officePhone' => 'required|string|max:255',
            'supplierDescription' => 'required|string|max:255',
            'group' => 'required|array',
            'group.*' => 'integer|exists:product_groups,id',
            'Secgroup' => 'required|array',
            'Secgroup.*' => 'integer',
            'company_header' => 'required|string|max:255',
            'bank' => 'required|string|max:255',
            'bank_address' => 'required',
            'swift_code' => 'required|string|max:255',
            'chips_no' => 'required',
            'beneficiary_name' => 'required|string|max:255',
            'account_no' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if ($request->status != $user->status) {
            $this->logEvent('Supplier', 'Supplier ID ' . $user->userid . ' status has been changed to ' . $request->status . '.');
        }
        // Update user information


        // Update buyer profile data
        $user->update([
            'name' => $request->name,
            'address' => $request->address,
            // 'supplier_id' => $request->supplier_id,
            'status' => $request->status,
            'website' => $request->website,
            'contact' => $request->contact,
            'office_phone' => $request->officePhone,
            'supplier_description' => $request->supplierDescription,
            'group' => $request->group,
            'sec_group' => $request->Secgroup,
            'company_header' => $request->company_header,
            'bank' => $request->bank,
            'bank_address' => $request->bank_address,
            'swift_code' => $request->swift_code,
            'chips_no' => $request->chips_no,
            'beneficiary_name' => $request->beneficiary_name,
            'account_no' => $request->account_no,
        ]);

        // Optionally, update roles using Spatie permissions
        // $user->syncRoles(['Supplier']);

        return response()->json(['message' => 'Successfully updated user!'], 200);
    }
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
        // dd($data['otp']);
        $validator = Validator::make($data, [
            'status' => 'required',
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'otp' => 'nullable|string|min:8|regex:/^[^\s]+$/',
            'permissions' => 'nullable|array',
            'contact_person' => 'nullable|string',
            'contact_number' => 'nullable|string',
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


            if ($request->status != $user->status) {
                $roles = $user->getRoleNames()->toArray();
                $role = $roles[0];
                $this->logEvent("$role", 'User ID ' . $user->userid . ' status has been changed to ' . $data['status'] . '.');
            }

            $user->update($data);

            if ($request->otp) {

                Mail::to($user->email)->send(new OTPMail($data['otp']));
                // $user->password = Hash::make($request->password);
                // $user->save();

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
            DB::beginTransaction();
            $user = User::findOrFail($id);

            $roles = $user->getRoleNames()->toArray();
            $role = $roles[0];
            $this->logEvent("$role", "User ID '$user->userid' has been deleted.");
            $user->delete();

            DB::commit();
            return response()->json(['message' => 'User deleted successfully'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            // throw $e;
            return response()->json(['message' => 'Failed to delete data', 'error' => $e->getMessage()], 500);
        }
    }

}
