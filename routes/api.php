<?php

use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;
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
Route::get('supplierOrder', [UserController::class, 'supplierOrder']);
Route::get('buyerOrder', [UserController::class, 'buyerOrder']);
Route::get('products', [UserController::class, 'products']);
Route::get('supplier_profiles/{id}', [UserController::class, 'supplier_profiles']);

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
Route::get('product_group_get_all', [ProductController::class, 'product_group_get_all']);

//price_inquiry
Route::post('price_inquiry', [ProductController::class, 'price_inquiry']);
Route::post('update_price_inquiry/{id}', [ProductController::class, 'update_price_inquiry']);
Route::get('price_inquiry_get', [ProductController::class, 'price_inquiry_get']);
Route::delete('PriceDelete/{id}', [ProductController::class, 'PriceDelete']);

//Orders
Route::post('orderentry', [OrderController::class, 'orderentry']);
Route::post('saveSelectedOrders', [OrderController::class, 'saveSelectedOrders']);
Route::get('orderentry', [OrderController::class, 'orderentryget']);
Route::get('orderAll', [OrderController::class, 'orderAll']);
Route::get('orderentry/{id}', [OrderController::class, 'orderentrygetID']);
Route::post('orderentry/{id}', [OrderController::class, 'orderUpdate']);
Route::delete('orderDelete/{id}', [OrderController::class, 'orderDelete']);
Route::post('placeAll', [OrderController::class, 'placeAll']);

//Shipment
Route::post('create_so', [ShipmentController::class, 'create_so']);
Route::get('shipmentget', [ShipmentController::class, 'shipmentget']);
Route::post('shipment', [ShipmentController::class, 'shipment']);







Route::post('statement', [ProductController::class, 'statement']);
// Auth
// Adding Products
Route::delete('prodDelete/{id}', [ProductController::class, 'prodDelete']);
Route::post('addprod', [ProductController::class, 'addprod']);


Route::middleware('auth:sanctum')->group(function () {

    Route::get('SupplierOrder', [OrderController::class, 'SupplierOrder']);
    Route::post('supplier/placeAll', [OrderController::class, 'supplierPlace']);
});

