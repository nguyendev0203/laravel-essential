<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShowRoomsController;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RoomTypeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/test', function () {
    return "Good Bye";
});

Route::get('/rooms/{roomType?}', ShowRoomsController::class);

Route::resource('/bookings', BookingController::class);

Route::resource('/room_types', RoomTypeController::class);
