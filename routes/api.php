<?php

use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\StatController;
use App\Http\Controllers\buyer\BuyerController;
use App\Http\Controllers\buyer\BuyerOrderController;
use App\Http\Controllers\buyer\BuyerShipmentController;
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
use Spatie\Permission\Models\Permission;

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

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/get-permissions', function () {
        return auth()->check() ? auth()->user()->jsPermissions() : 0;
    });

});




// <-- Buyer Routes -->
Route::group(['prefix' => 'buyer', 'middleware' => ['auth:sanctum', 'role:Buyer']], function () {

    // Product
    Route::get('products', [UserController::class, 'products']);
    Route::get('product/{id}', [BuyerController::class, 'product']);
    Route::get('product_group_get', [ProductController::class, 'product_group_get']);
    Route::get('product_group_get_all', [ProductController::class, 'product_group_get_all']);

    // Price Inquiry
    Route::resource('price_inquiry', InquiryController::class)->except([
        'update'
    ]);
    Route::post('price_inquiry/{price_inquiry}', [InquiryController::class, 'update'])->name('price_inquiry.update');

    //Orders
    Route::resource('order', BuyerOrderController::class)->except(['update', 'create']);
    Route::get('orderentry/{id}', [BuyerOrderController::class, 'orderentrygetID']);
    Route::post('orderentry/{id}', [BuyerOrderController::class, 'update']);
    Route::post('ordercreate', [BuyerOrderController::class, 'update']);
    Route::get('printview/{id}', [BuyerOrderController::class, 'printviewget']);
    Route::post('printview/{id}', [BuyerOrderController::class, 'printview']);

    // Shipments
    Route::resource('shipments', BuyerShipmentController::class)->except(['update', 'create', 'store']);
    Route::post('shipments/{id}', [BuyerShipmentController::class, 'update']);

    // Finance
    Route::get('so', [BuyerShipmentController::class, 'buyerSos']);
    Route::get('so/{id}', [BuyerShipmentController::class, 'buyerSo']);
    Route::post('payment', [BuyerShipmentController::class, 'store']);
    Route::post('reject', [BuyerShipmentController::class, 'reject']);
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

// <-- Admin Routes -->
Route::middleware(['auth:sanctum', 'role:Admin'])->group(function () {

    // Fetching Users
    Route::get('users', [UserController::class, 'users'])->middleware('can:issueNewLoginIdPassword,setAccessAuthority,userManagement');
    Route::get('supplier', [UserController::class, 'supplier'])->middleware('can:addNewSupplierEntry,setEditSupplierIDCode');
    Route::get('buyer', [UserController::class, 'buyer'])->middleware('can:addNewBuyerEntry,editBuyerEntry');
    Route::get('supplierOrder', [UserController::class, 'supplierOrder']);
    Route::get('buyerOrder', [UserController::class, 'buyerOrder']);
    Route::get('supplier_profiles/{id}', [UserController::class, 'supplier_profiles']);

    // Adding Users
    Route::post('addbuyers', [UserController::class, 'buyers'])->middleware('can:addNewBuyerEntry,editBuyerEntry');
    Route::post('addsupliers', [UserController::class, 'suppliers'])->middleware('can:setEditSupplierIDCode,editSupplierEntry');

    // Updating Users
    Route::get('editusers/{id}', [UserController::class, 'usersEdit'])->middleware('can:issueNewLoginIdPassword,setAccessAuthority,userManagement');
    Route::put('updateusers/{id}', [UserController::class, 'update'])->middleware('can:issueNewLoginIdPassword,setAccessAuthority,userManagement');
    Route::post('addusers', [UserController::class, 'addUser'])->middleware('can:issueNewLoginIdPassword,setAccessAuthority,userManagement');
    Route::delete('userDelete/{id}', [UserController::class, 'delUser'])->middleware('can:issueNewLoginIdPassword,setAccessAuthority,userManagement');

    //Product-group
    Route::post('product_group', [ProductController::class, 'product_group'])->middleware('can:createProductGroup');
    Route::get('product_group_get', [ProductController::class, 'product_group_get'])->middleware('can:createProductGroup');
    Route::get('product_group_get_all', [ProductController::class, 'product_group_get_all'])->middleware('can:createProductGroup');

    //price_inquiry
    Route::post('price_inquiry', [ProductController::class, 'price_inquiry'])->middleware('can:createPriceInquiry');
    Route::post('update_price_inquiry/{id}', [ProductController::class, 'update_price_inquiry']);
    Route::get('price_inquiry_get', [ProductController::class, 'price_inquiry_get']);
    Route::delete('PriceDelete/{id}', [ProductController::class, 'PriceDelete']);

    //Orders
    Route::post('orderentry', [OrderController::class, 'orderentry'])->middleware('can:orderGeneralSinglePage,createNewOrder');
    Route::post('saveSelectedOrders', [OrderController::class, 'saveSelectedOrders']);
    Route::get('orderentry', [OrderController::class, 'orderentryget'])->middleware('can:orderGeneralSinglePage,createNewOrder');
    Route::get('orderAll', [OrderController::class, 'orderAll'])->middleware('can:miLungOrderPriceEnquiry');
    Route::get('orderentry/{id}', [OrderController::class, 'orderentrygetID'])->middleware('can:editOrderDetails');
    Route::post('orderentry/{id}', [OrderController::class, 'orderUpdate'])->middleware('can:editOrderDetails,voidOrder');
    Route::delete('orderDelete/{id}', [OrderController::class, 'orderDelete']);
    Route::post('placeAll', [OrderController::class, 'placeAll']);
    Route::get('shipmentsget', [ShipmentController::class, 'shipmentsget']);
    Route::get('Suppliers', [OrderController::class, 'Suppliers']);
    Route::get('printview/{id}', [BuyerOrderController::class, 'printviewget'])->middleware('can:printviewConfirmRejectButton');
    Route::post('printview/{id}', [BuyerOrderController::class, 'printview'])->middleware('can:printviewConfirmRejectButton');
    Route::post('masscargo/{id}', [SupplierOrderController::class, 'masscargo'])->middleware('can:massCargoPhotoApproval');
    //Shipment
    Route::post('create_so', [ShipmentController::class, 'create_so'])->middleware('can:createSONumber');
    Route::delete('soDelete/{id}', [ShipmentController::class, 'soDelete'])->middleware('can:editShipmentOverview');
    Route::get('shipmentget', [ShipmentController::class, 'shipmentget'])->middleware('can:shipmentOverview,editShipmentOverview');
    Route::get('shipmentget/{id}', [ShipmentController::class, 'shipmentgetid'])->middleware('can:editShipmentOverview');
    Route::post('shipment/{id}', [ShipmentController::class, 'shipment'])->middleware('can:editShipmentOverview');
    // Information
    Route::post('create_doc', [ShipmentController::class, 'create_doc'])->middleware('can:exportShippingDocuments');
    Route::get('information/{id}', [ShipmentController::class, 'information'])->middleware('can:exportShippingDocuments');

    // Finance
    Route::get('so/{id}', [ShipmentController::class, 'SupplierSo']);
    Route::get('invoice/{id}', [ShipmentController::class, 'invoice'])->middleware('can:accountReceivable');
    Route::get('buyerFinance', [UserController::class, 'buyerFinance'])->middleware('can:accountReceivable');
    Route::post('rcvablesave/{id}', [ShipmentController::class, 'rcvablesave'])->middleware('can:accountReceivable');

    // Statistics
    Route::get('statfilter', [StatController::class, 'statfilter']);
    Route::post('statfilter', [StatController::class, 'statfilterSearch']);


    // Doc Routes
    Route::post('infosave/{id}', [SupplierShipmentController::class, 'infosave']);

    Route::post('statement', [ProductController::class, 'statement']);

    // Adding Products
    Route::get('products', [UserController::class, 'products'])->middleware('can:addProductEntry,editProductEntry,accessImportExportCertificateTestingReport');
    Route::delete('prodDelete/{id}', [ProductController::class, 'prodDelete'])->middleware('can:addProductEntry,editProductEntry,accessImportExportCertificateTestingReport');
    Route::post('addprod', [ProductController::class, 'addprod'])->middleware('can:addProductEntry,editProductEntry,accessImportExportCertificateTestingReport');

});

