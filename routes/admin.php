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


Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ], function () {

    Route::group(['namespace' => 'Dashboard' ,'prefix'=>'admin','middleware' => 'guest:admin'], function () {
        Route::get('login', 'LoginController@index')->name('admin.login');
        Route::post('login', 'LoginController@login')->name('admin.getlogin');
    });

    Route::group(['namespace' => 'Dashboard','prefix'=>'admin', 'middleware' => 'auth:admin'], function () {
        Route::get('/', 'DashboardController@index')->name('admin.dashboard');
        Route::get('logout', 'LoginController@logout')->name('admin.logout');

        Route::group(['prefix' => 'settings'], function () {
            Route::get('shipping-methods/{type}', 'SettingsController@editShipping')->name('edit.shipping');
            Route::PUT('shipping-methods/{id}', 'SettingsController@updateShipping')->name('update.shipping');
        });

        Route::group(['prefix' => 'profile'], function () {
            Route::get('edit', 'ProfileController@editProfile')->name('edit.profile');
            Route::PUT('update', 'ProfileController@updateProfile')->name('update.profile');
        });

        Route::group(['prefix' => 'main_categories'], function () {
            Route::get('/', 'MainCategoryController@index')->name('admin.maincategories');
            Route::get('create', 'MainCategoryController@create')->name('admin.maincategories.create');
            Route::post('store', 'MainCategoryController@store')->name('admin.maincategories.store');
            Route::get('edit/{id}', 'MainCategoryController@edit')->name('admin.maincategories.edit');
            Route::PUT('update/{id}', 'MainCategoryController@update')->name('admin.maincategories.update');
            Route::get('delete/{id}', 'MainCategoryController@delete')->name('admin.maincategories.delete');
            Route::get('changestatus/{id}', 'MainCategoryController@changestatus')->name('admin.maincategories.changestatus');
        });
        Route::group(['prefix' => 'sub_categories'], function () {
            Route::get('/', 'SubCategoryController@index')->name('admin.subcategories');
            Route::get('create', 'SubCategoryController@create')->name('admin.subcategories.create');
            Route::post('store', 'SubCategoryController@store')->name('admin.subcategories.store');
            Route::get('edit/{id}', 'SubCategoryController@edit')->name('admin.subcategories.edit');
            Route::PUT('update/{id}', 'SubCategoryController@update')->name('admin.subcategories.update');
            Route::get('delete/{id}', 'SubCategoryController@delete')->name('admin.subcategories.delete');
            Route::get('changestatus/{id}', 'SubCategoryController@changestatus')->name('admin.subcategories.changestatus');
        });

    });

});
