<?php

namespace App\Http\Controllers;

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
    public function supplier()
    {
        $users = User::withRole('Supplier')->get();


        // dd($responseData);
        return response()->json($users, JsonResponse::HTTP_OK);
    }
    public function buyer()
    {
        $users = User::withRole('Buyer')->get();


        // dd($responseData);
        return response()->json($users, JsonResponse::HTTP_OK);
    }
    public function addUser(Request $request)
    {
        // dd($request);
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'status' => 'required|string|in:active,inactive',
            'buyer_id' => 'required|integer',
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

        // $user->update([
        //     'status' => $data['status'],
        //     'name' => $data['name'],
        //     'email' => $data['email'],
        // ]);

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
            return response()->json(['error' => 'Error deleting user'], 500);
        }
    }
}
