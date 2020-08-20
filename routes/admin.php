<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['namespace'=>'Dashboard','middleware'=>'guest:admin'],function (){
    Route::get('login','LoginController@index')->name('admin.login');
    Route::post('login','LoginController@login')->name('admin.getlogin');
});

Route::group(['namespace'=>'Dashboard','middleware'=>'auth:admin'],function (){
    Route::get('/','DashboardController@index')->name('admin.dashboard');
});

