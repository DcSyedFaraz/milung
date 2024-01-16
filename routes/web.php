<?php

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

// Route::get('/done', function () {
//     $user =[
//         'name'=>'Supplier',
//         'email'=>'supplier@gmail.com',
//         'password' => Hash::make('12345678'),
//         'email_verified_at' => date('Y-m-d h:i:s'),
//     ];

//     $userd = User::create($user);
//     $userd->assignRole('Supplier');
//     return 'done';
// });
Route::group(['namespace' => 'web'], function () {

    Route::get('/{any}', function () {
        return view('welcome');
    })->where('any','.*');
});
