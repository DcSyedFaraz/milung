<?php

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
Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);
Route::get('users', [UserController::class, 'users']);
Route::get('supplier', [UserController::class, 'supplier']);
Route::get('buyer', [UserController::class, 'buyer']);
Route::get('editusers/{id}', [UserController::class, 'usersEdit']);
Route::put('updateusers/{id}', [UserController::class, 'update']);
Route::post('addusers', [UserController::class, 'addUser']);
Route::delete('userDelete/{id}', [UserController::class, 'delUser']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
