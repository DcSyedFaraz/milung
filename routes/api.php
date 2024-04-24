<?php

use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\StatController;
use App\Http\Controllers\buyer\BuyerController;
use App\Http\Controllers\buyer\BuyerOrderController;
use App\Http\Controllers\buyer\InquiryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\supplier\SupplierOrderController;
use App\Http\Controllers\supplier\SupplierShipmentController;
use App\Http\Controllers\supplier\SuppProductController;
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

Route::group(['middleware' => []], function () {


});




// <-- Buyer Routes -->
Route::group(['prefix' => 'buyer', 'middleware' => ['auth:sanctum', 'role:Buyer']], function () {

    // Product
    Route::get('product/{id}', [BuyerController::class, 'product']);
    Route::get('product_group_get', [ProductController::class, 'product_group_get']);
    Route::get('product_group_get_all', [ProductController::class, 'product_group_get_all']);

    // Price Inquiry
    Route::resource('price_inquiry', InquiryController::class)->except([
        'update'
    ]);
    Route::post('price_inquiry/{price_inquiry}', [InquiryController::class, 'update'])->name('price_inquiry.update');

    //Orders
    Route::resource('order', BuyerOrderController::class)->except([
        'update'
    ]);
    Route::get('orderentry/{id}', [BuyerOrderController::class, 'orderentrygetID']);
    Route::post('orderentry/{id}', [BuyerOrderController::class, 'update']);
    Route::post('ordercreate', [BuyerOrderController::class, 'update']);
    Route::get('printview/{id}', [BuyerOrderController::class, 'printviewget']);
    Route::post('printview/{id}', [BuyerOrderController::class, 'printview']);

});

// <-- Supplier Routes -->
Route::group(['prefix' => 'supplier', 'middleware' => ['auth:sanctum', 'role:Supplier']], function () {

    // Shipment
    Route::get('shipments', [SupplierShipmentController::class, 'shipments']);
    Route::post('shipment/{id}', [SupplierShipmentController::class, 'shipment']);
    Route::post('receipt-note', [SupplierShipmentController::class, 'receipt_note']);

    // Order
    Route::get('orderentry', [SupplierOrderController::class, 'orderentryget']);
    Route::get('orderentry/{id}', [SupplierOrderController::class, 'orderentrygetID']);
    Route::post('printview/{id}', [SupplierOrderController::class, 'printview']);
    Route::get('printview/{id}', [SupplierOrderController::class, 'printviewget']);
    Route::post('masscargo/{id}', [SupplierOrderController::class, 'masscargo']);
    Route::get('SupplierOrder', [OrderController::class, 'SupplierOrder']);
    Route::post('supplier/placeAll', [OrderController::class, 'supplierPlace']);

    //price_inquiry
    Route::get('price_inquiry_get', [SuppProductController::class, 'price_inquiry_get']);
    Route::get('price_inquiry_get/{id}', [SuppProductController::class, 'price_inquiry_getOne']);
    Route::post('price_inquiry', [SuppProductController::class, 'price_inquiry']);
    Route::post('update_price_inquiry/{id}', [SuppProductController::class, 'update_price_inquiry']);
    Route::delete('PriceDelete/{id}', [SuppProductController::class, 'PriceDelete']);

    // Supplier Routes
    Route::get('suppliershipments', [SupplierShipmentController::class, 'suppliershipments']);
    Route::get('suppliershipments/{id}', [SupplierShipmentController::class, 'suppliershipment']);
    Route::post('suppliershipments/{id}', [SupplierShipmentController::class, 'suppliershipmentUpdate']);

});
Route::middleware(['auth:sanctum', 'role:Admin'])->group(function () {

    // Fetching Users
    Route::get('users', [UserController::class, 'users']);
    Route::get('supplier', [UserController::class, 'supplier']);
    Route::get('buyer', [UserController::class, 'buyer']);
    Route::get('supplierOrder', [UserController::class, 'supplierOrder']);
    Route::get('buyerOrder', [UserController::class, 'buyerOrder']);
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
    Route::get('shipmentsget', [ShipmentController::class, 'shipmentsget']);

    //Shipment
    Route::post('create_so', [ShipmentController::class, 'create_so']);
    Route::delete('soDelete/{id}', [ShipmentController::class, 'soDelete']);
    Route::get('shipmentget', [ShipmentController::class, 'shipmentget']);
    Route::get('shipmentget/{id}', [ShipmentController::class, 'shipmentgetid']);
    Route::post('shipment/{id}', [ShipmentController::class, 'shipment']);
    // Information
    Route::post('create_doc', [ShipmentController::class, 'create_doc']);
    Route::get('information/{id}', [ShipmentController::class, 'information']);

    // Finance
    Route::get('so/{id}', [ShipmentController::class, 'SupplierSo']);

    // Statistics
    Route::get('statfilter', [StatController::class, 'statfilter']);
    Route::post('statfilter', [StatController::class, 'statfilterSearch']);


    // Doc Routes
    Route::post('infosave/{id}', [SupplierShipmentController::class, 'infosave']);

    Route::post('statement', [ProductController::class, 'statement']);

    // Adding Products
    Route::get('products', [UserController::class, 'products']);
    Route::delete('prodDelete/{id}', [ProductController::class, 'prodDelete']);
    Route::post('addprod', [ProductController::class, 'addprod']);

});

