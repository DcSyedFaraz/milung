<?php

use App\Models\Order;
use App\Models\Products;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/done', function () {
    Artisan::call('migrate:fresh --seed');
    Artisan::call('optimize:clear');

    return 'done';
});
Route::get('search', function () {
    $query = 'a'; // <-- Change the query for testing.
    // Visit the /search route in your web browser to see articles that match the test $query.

    $articles = Order::search($query)->get();

    return $articles;
});
Route::group(['namespace' => 'web'], function () {

    Route::get('/{any}', function () {
        return view('welcome');
    })->where('any', '.*');
});
