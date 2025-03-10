<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/register', function () {
    return view('register');
});
Route::get('/vendor-register', function () {
    return view('vendor-register');
});

//dashboard

Route::get('/home', function () {
    return view('dashboard/home');
});

Route::get('/update-profile', function () {
    return view('dashboard/update-profile');
});

Route::get('/vendors', function () {
    return view('dashboard/vendors');
});

Route::get('/locations', function () {
    return view('dashboard/locations');
});

Route::get('/cart', function () {
    return view('dashboard/cart');
});

Route::get('/order-pending', function () {
    return view('dashboard/order-pending');
});

Route::get('/order-confirmed', function () {
    return view('dashboard/order-confirmed');
});

Route::get('/order-delivered', function () {
    return view('dashboard/order-delivered');
});

Route::get('/order-canceled', function () {
    return view('dashboard/order-canceled');
});

Route::get('/store', function () {
    return view('dashboard/store');
});

Route::get('/rider', function () {
    return view('dashboard/rider');
});

Route::get('/products', function () {
    return view('dashboard/products');
});

Route::get('/vendor-order-pending', function () {
    return view('dashboard/vendor-order-pending');
});

Route::get('/vendor-order-confirmed', function () {
    return view('dashboard/vendor-order-confirmed');
});

Route::get('/vendor-order-delivered', function () {
    return view('dashboard/vendor-order-delivered');
});

Route::get('/vendor-order-canceled', function () {
    return view('dashboard/vendor-order-canceled');
});

Route::get('/delivery', function () {
    return view('dashboard/delivery');
});