<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShowRoomsController;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RoomTypeController;
use Illuminate\Support\Facades\Hash;

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

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/test', function () {
    $hash = Hash::make('black-saber');
    var_dump($hash);
    var_dump(Hash::check('black-saber', $hash));
    var_dump(Hash::needsRehash($hash));
    $oldHash = Hash::make(
        'black-saber',
        [
            'rounds' => 12,
        ]
    );
    var_dump($oldHash);
    var_dump(Hash::needsRehash($oldHash));
    var_dump(Hash::make('black-saber'));
})->middleware('verified');

Route::get('/rooms/{roomType?}', ShowRoomsController::class);

Route::resource('/bookings', BookingController::class);

Route::resource('/room_types', RoomTypeController::class);
