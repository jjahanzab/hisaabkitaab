<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


Route::get('/setup', 'SystemInfoController@setup');

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
Route::group(['middleware' => 'validated'], function () {

    
    Route::get('/', function () {
        return view('welcome');
    });

    Auth::routes();

    // preventbackhistory middleware //
	Route::group(['middleware' => 'preventbackhistory'], function () {

        Route::get('/home', 'HomeController@index')->name('home');
        Route::get('/loadChart', 'HomeController@loadChart')->name('load.chart');
        /*
        |--------------------------------------------------------------------------
        | Order Routes
        |--------------------------------------------------------------------------
        */
        Route::group(['prefix' => 'order', 'as' => 'order.'], function () {
            Route::get('/show', 'OrderController@show')->name('show');
            Route::get('/create', 'OrderController@create')->name('create');
            Route::post('/store', 'OrderController@store')->name('store');
            Route::get('/delete/{slug}', 'OrderController@destroy')->name('delete');
            Route::post('/fetchProducts', 'OrderController@fetchProducts')->name('fetch.products');
            Route::post('/productDetail', 'OrderController@productDetail')->name('product.detail');
            Route::get('/fetchOrderNumber', 'OrderController@fetchOrderNumber')->name('fetch.number');
            Route::post('/saveOrderList', 'OrderController@saveOrderList')->name('list.save');
    
            Route::get('/deleteReport/{slug}', 'OrderController@deleteReport')->name('delete.report');
            Route::post('/getOrdersList', 'OrderController@getOrdersList')->name('detail.list');
            Route::get('/search', 'OrderController@searchReport')->name('search.report');
            Route::get('/month', 'OrderController@monthReport')->name('month.report');
            Route::get('/year', 'OrderController@yearReport')->name('year.report');
        });
        /*
        |--------------------------------------------------------------------------
        | Category Routes
        |--------------------------------------------------------------------------
        */
        Route::group(['prefix' => 'category', 'as' => 'category.'], function () {
            Route::get('/', 'CategoryController@index')->name('index');
            Route::get('/create', 'CategoryController@create')->name('create');
            Route::post('/store', 'CategoryController@store')->name('store');
            Route::get('/edit/{slug}', 'CategoryController@edit')->name('edit');
            Route::post('/update', 'CategoryController@update')->name('update');
            Route::get('/delete/{slug}', 'CategoryController@destroy')->name('delete');
        });
        /*
        |--------------------------------------------------------------------------
        | Product Routes
        |--------------------------------------------------------------------------
        */
        Route::group(['prefix' => 'product', 'as' => 'product.'], function () {
            Route::get('/', 'ProductController@index')->name('index');
            Route::get('/create', 'ProductController@create')->name('create');
            Route::post('/store', 'ProductController@store')->name('store');
            Route::get('/edit/{slug}', 'ProductController@edit')->name('edit');
            Route::post('/update', 'ProductController@update')->name('update');
            Route::get('/delete/{slug}', 'ProductController@destroy')->name('delete');
        });
        /*
        |--------------------------------------------------------------------------
        | Setting Routes
        |--------------------------------------------------------------------------
        */
        Route::group(['prefix' => 'setting', 'as' => 'setting.'], function () {
            Route::get('/', 'SettingController@create')->name('index');
            Route::post('/store', 'SettingController@store')->name('store');
        });
    });
    

});