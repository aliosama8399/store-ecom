<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Site Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');



Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ], function () {

    Route::group(['namespace' => 'Site'/*, 'middleware' => 'guest'*/], function () {
        Route::get('/','HomeController@home')->name('home')->middleware('VerifyUser');
        Route::get('category/{slug}','CategoryController@productBySlug')->name('category');

    });




    Route::group(['namespace' => 'Site', 'middleware' => ['auth','VerifyUser']], function () {
        Route::get('profile', function () {
            return "You Are Auth";

        });

    });
    Route::group(['namespace' => 'Site', 'middleware' => 'auth'], function () {
        Route::post('verify-user','VerificationCodeController@verify')->name('verify-user');
        Route::get('verified','VerificationCodeController@getVerifiedPage')->name('get.verification.form');

    });

    Route::group(['namespace' => 'Site', 'middleware' => 'auth'], function () {
        Route::post('wishlist','WishlistController@store')->name('wishlist.store');
        Route::delete('wishlist/{productId}','WishlistController@destroy')->name('wishlist.destroy');
        Route::get('wishlist/products','WishlistController@index')->name('wishlist.products.index');

    });



});
