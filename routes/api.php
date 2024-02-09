<?php

use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Auth
Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);

// Fetching Users
Route::get('users', [UserController::class, 'users']);
Route::get('supplier', [UserController::class, 'supplier']);
Route::get('buyer', [UserController::class, 'buyer']);
Route::get('products', [UserController::class, 'products']);

// Adding Users
Route::post('addbuyers', [UserController::class, 'buyers']);
Route::post('addsupliers', [UserController::class, 'suppliers']);

// Updating Users
Route::get('editusers/{id}', [UserController::class, 'usersEdit']);
Route::put('updateusers/{id}', [UserController::class, 'update']);
Route::post('addusers', [UserController::class, 'addUser']);
Route::delete('userDelete/{id}', [UserController::class, 'delUser']);

//Product-group
Route::post('product_group', [ProductController::class, 'product_group']);
Route::get('product_group_get', [ProductController::class, 'product_group_get']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('statement', [ProductController::class, 'statement']);
Route::middleware('auth:sanctum')->group(function () {
    // Adding Products
    Route::delete('prodDelete/{id}', [ProductController::class, 'prodDelete']);
    Route::post('addprod', [ProductController::class, 'addprod']);

    // Your authenticated routes
});

