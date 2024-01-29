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

Route::get('/done', function () {
    Artisan::call('migrate:fresh --seed');
    // $user =[
    //     'first_name'=>'admin',
    //     'last_name'=>'admin',
    //     'email'=>'admin@gmail.com',
    //     'password' => Hash::make('12345678'),
    //     'email_verified_at' => date('Y-m-d h:i:s'),
    // ];

    // $userd = User::create($user);
    // $userd->assignRole('Admin');
    // $buy =[
    //     'first_name'=>'buyer',
    //     'last_name'=>'buyer',
    //     'email'=>'buyer@gmail.com',
    //     'password' => Hash::make('12345678'),
    //     'email_verified_at' => date('Y-m-d h:i:s'),
    // ];

    // $buyr = User::create($buy);
    // $buyr->assignRole('Buyer');
    // $supp =[
    //     'first_name'=>'supplier',
    //     'last_name'=>'supplier',
    //     'email'=>'supplier@gmail.com',
    //     'password' => Hash::make('12345678'),
    //     'email_verified_at' => date('Y-m-d h:i:s'),
    // ];

    // $suppl = User::create($supp);
    // $suppl->assignRole('Supplier');
    return 'done';
});
Route::group(['namespace' => 'web'], function () {

    Route::get('/{any}', function () {
        return view('welcome');
    })->where('any','.*');
});
