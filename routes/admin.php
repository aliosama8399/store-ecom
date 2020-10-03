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
        Route::group(['prefix' => 'brands'], function () {
            Route::get('/', 'BrandController@index')->name('admin.brands');
            Route::get('create', 'BrandController@create')->name('admin.brands.create');
            Route::post('store', 'BrandController@store')->name('admin.brands.store');
            Route::get('edit/{id}', 'BrandController@edit')->name('admin.brands.edit');
            Route::PUT('update/{id}', 'BrandController@update')->name('admin.brands.update');
            Route::get('delete/{id}', 'BrandController@delete')->name('admin.brands.delete');
            Route::get('changestatus/{id}', 'BrandController@changestatus')->name('admin.brands.changestatus');
        });

        Route::group(['prefix' => 'tags'], function () {
            Route::get('/', 'TagsController@index')->name('admin.tags');
            Route::get('create', 'TagsController@create')->name('admin.tags.create');
            Route::post('store', 'TagsController@store')->name('admin.tags.store');
            Route::get('edit/{id}', 'TagsController@edit')->name('admin.tags.edit');
            Route::PUT('update/{id}', 'TagsController@update')->name('admin.tags.update');
            Route::get('delete/{id}', 'TagsController@delete')->name('admin.tags.delete');
        });
        Route::group(['prefix' => 'products'], function () {
            Route::get('/', 'ProductController@index')->name('admin.products');
            Route::get('general-information', 'ProductController@create')->name('admin.products.general.create');
            Route::post('store-general-information', 'ProductController@store')->name('admin.products.general.store');

            Route::get('price/{id}', 'ProductController@getPrice')->name('admin.products.price');
            Route::post('price', 'ProductController@storePrice')->name('admin.products.price.store');


            Route::get('edit/{id}', 'ProductController@edit')->name('admin.products.edit');
            Route::PUT('update/{id}', 'ProductController@update')->name('admin.products.update');
            Route::get('delete/{id}', 'ProductController@delete')->name('admin.products.delete');
        });

    });

});
