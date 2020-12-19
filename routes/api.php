<?php

use Illuminate\Http\Request;

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

Route::group(['prefix' => 'v1'], function () {
    Route::group(['prefix' => 'user'], function () {
        Route::post('login', 'User\Auth\LoginController@userLogin')->name('login');
        Route::post('register-customer', 'User\Auth\RegisterController@registerUser');
    });
    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('room-list', 'Room\RoomController@roomList');
        Route::post('book-room', 'Room\RoomController@bookRoom');
        Route::post('checkout', 'Room\RoomController@checkout');
        Route::get('booking-list', 'Room\RoomController@bookingList');
    });
});
