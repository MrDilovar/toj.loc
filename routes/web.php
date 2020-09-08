<?php

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

Route::group(['namespace'=>'Guest', 'as'=>'guest.'], function () {
    Route::get('/categories/{slug}', ['as'=>'categories', 'uses'=>'CategoryController@index'])->where('slug','^[a-zA-Z0-9-_\/]+$');
    Route::post('/filters/count', 'CategoryController@filters_count');
    Route::get('/', 'HomeController@home')->name('home');
    Route::get('/product/{product}', 'HomeController@product')->where('product', '[0-9]+')->name('product');
    Route::get('/order/{customer}', 'HomeController@order')->where('customer', '[0-9]+')->name('order');
    Route::get('/privacy', 'HomeController@privacy')->name('privacy');
});

Route::group(['prefix'=>'cart', 'as'=>'cart.'], function () {
    Route::get('/', 'CartController@index')->name('index');
    Route::post('/{product}', 'CartController@store')->name('store');
    Route::patch('/{product}', 'CartController@update')->name('update');
    Route::delete('/{product}', 'CartController@destroy')->name('destroy');
});

Route::group(['as'=>'checkout.'], function () {
    Route::get('/checkout', 'CheckoutController@index')->name('index');
    Route::post('/checkout', 'CheckoutController@store')->name('store');
});

Route::get('feedback/create', 'Admin\FeedbackController@create')->name('feedback.create');
Route::post('feedback/store', 'Admin\FeedbackController@store')->name('feedback.store');

Auth::routes(['verify' => true]);

Route::group([
    'prefix'=>'email',
    'as'=>'email.',
    'namespace'=>'Auth',
    'middleware'=>['web']
], function (){
    Route::post('/email', [
        'middleware'=>['auth', 'verified'],
        'uses'=>'ResetEmailController@sendResetLinkEmail'
    ])->name('email');
    Route::get('/reset/{token}', 'ResetEmailController@reset')->name('reset');
});

Route::group([
    'prefix'=>'store',
    'as'=>'store.',
    'namespace'=>'Store',
    'middleware'=>['web', 'auth', 'verified', 'store']
], function () {
    Route::get('/', 'StoreController@index')->name('index');
    Route::get('/profile', 'StoreController@profile_show')->name('profile.show');
    Route::post('/profile', 'StoreController@profile_update')->name('profile.update');
    Route::post('/profile/logo', 'StoreController@profile_logo_update')->name('profile.logo.update');
    Route::post('/profile/password', 'StoreController@profile_password_update')->name('profile.password.update');
    Route::post('/product/upload-image', 'ProductController@upload_image')->name('product.upload_image');
    Route::resource('/product', 'ProductController')->except('show');
    Route::resource('/order', 'OrderController');
});

Route::group([
    'prefix'=>'admin',
    'as'=>'admin.',
    'namespace'=>'Admin',
    'middleware'=>['web', 'auth', 'verified', 'admin']
], function () {
    Route::get('/', 'AdminController@index')->name('index');
    Route::resource('feedback', 'FeedbackController', ['except'=>['create', 'store']]);
    Route::group(['as'=>'categories.properties.'], function () {
        Route::get('categories/{id}/properties', 'CategoryPropertyController@index')->name('index');
        Route::get('categories/{id}/properties/create', 'CategoryPropertyController@create')->name('create');
        Route::post('categories/{id}/properties', 'CategoryPropertyController@store')->name('store');
        Route::delete('categories/{id}/properties}', 'CategoryPropertyController@destroy')->name('destroy');
    });
    Route::resource('categories', 'CategoryController', ['except'=>['show']]);
    Route::resource('properties', 'PropertyController')->except(['show']);
    Route::resource('properties.property_values', 'PropertyValueController')->shallow()->except(['show']);
});
