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

    Route::group(['namespace' => 'Dashboard', 'prefix' => 'admin', 'middleware' => 'guest:admin'], function () {
        Route::get('login', 'LoginController@index')->name('admin.login');
        Route::post('login', 'LoginController@login')->name('admin.getlogin');
    });

    Route::group(['namespace' => 'Dashboard', 'prefix' => 'admin', 'middleware' => 'auth:admin'], function () {
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
        Route::group(['prefix' => 'brands', 'middleware' => 'can:brands'], function () {
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

            Route::get('stock/{id}', 'ProductController@getStock')->name('admin.products.stock');
            Route::post('stock', 'ProductController@storeStock')->name('admin.products.stock.store');

            Route::get('images/{id}', 'ProductController@getImages')->name('admin.products.images');
            Route::post('images', 'ProductController@storeImages')->name('admin.products.images.store');
            Route::post('imagesdb', 'ProductController@storeImagesDB')->name('admin.products.images.store.db');

            Route::get('edit/{id}', 'ProductController@edit')->name('admin.products.edit');
            Route::PUT('update/{id}', 'ProductController@update')->name('admin.products.update');
            Route::get('delete/{id}', 'ProductController@delete')->name('admin.products.delete');
        });

        Route::group(['prefix' => 'attributes'], function () {
            Route::get('/', 'AttributesController@index')->name('admin.attributes');
            Route::get('create', 'AttributesController@create')->name('admin.attributes.create');
            Route::post('store', 'AttributesController@store')->name('admin.attributes.store');
            Route::get('edit/{id}', 'AttributesController@edit')->name('admin.attributes.edit');
            Route::PUT('update/{id}', 'AttributesController@update')->name('admin.attributes.update');
            Route::get('delete/{id}', 'AttributesController@delete')->name('admin.attributes.delete');
        });


        Route::group(['prefix' => 'options'], function () {
            Route::get('/', 'OptionsController@index')->name('admin.options');
            Route::get('create', 'OptionsController@create')->name('admin.options.create');
            Route::post('store', 'OptionsController@store')->name('admin.options.store');
            Route::get('edit/{id}', 'OptionsController@edit')->name('admin.options.edit');
            Route::PUT('update/{id}', 'OptionsController@update')->name('admin.options.update');
            Route::get('delete/{id}', 'OptionsController@delete')->name('admin.options.delete');
        });

        Route::group(['prefix' => 'sliders'], function () {
            Route::get('/', 'SliderController@addImages')->name('admin.sliders.create');
            Route::post('images', 'SliderController@saveSliderImages')->name('admin.sliders.images.store');
            Route::post('images/db', 'SliderController@saveSliderImagesDB')->name('admin.sliders.images.store.db');

        });

        Route::group(['prefix' => 'roles'], function () {
            Route::get('/', 'RolesController@index')->name('admin.roles.index');
            Route::get('create', 'RolesController@create')->name('admin.roles.create');
            Route::post('store', 'RolesController@saveRole')->name('admin.roles.store');
            Route::get('/edit/{id}', 'RolesController@edit') ->name('admin.roles.edit') ;
            Route::post('update/{id}', 'RolesController@update')->name('admin.roles.update');
        });

        Route::group(['prefix' => 'users' , 'middleware' => 'can:users'], function () {
            Route::get('/', 'UsersController@index')->name('admin.users.index');
            Route::get('/create', 'UsersController@create')->name('admin.users.create');
            Route::post('/store', 'UsersController@store')->name('admin.users.store');
        });

    });

});
