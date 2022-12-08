<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ClockController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Auth::routes();

Route::post('register', [RegisterController::class, 'register'])->name('register');
Route::post('login', [LoginController::class, 'login'])->name('login');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::group(['middleware' => 'auth:api'], function() {

    Route::get('clock', [ClockController::class, 'retrieve'])->name('retrieve');
    Route::post('clock', [ClockController::class, 'create'])->name('create');
    Route::put('clock', [ClockController::class, 'update'])->name('update');
    Route::delete('clock', [ClockController::class, 'delete'])->name('delete');

    Route::get('clock/display', [ClockController::class, 'display'])->name('display');
});
