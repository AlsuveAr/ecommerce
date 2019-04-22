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
/*
Route::get('/', function () {
    return view('web.landing-page');
});
*/
Route::get('/', 'Web\LandingPageController@index')->name('landing-page');

Route::get('/shop', 'Web\ShopController@index')->name('shop.index');
Route::get('/shop/{product}', 'Web\ShopController@show')->name('shop.show');

//Rutas del carro de compras
Route::get('/cart', 'Web\CartController@index')->name('cart.index');
Route::post('/cart', 'Web\CartController@store')->name('cart.store');
Route::patch('/cart/{product}', 'Web\CartController@update')->name('cart.update');
Route::delete('/cart/{product}', 'Web\CartController@destroy')->name('cart.destroy');
Route::post('/cart/switchToSaveForLater/{product}', 'Web\CartController@switchToSaveForLater')->name('cart.switchToSaveForLater');
//Ruta de guardar para luego
Route::delete('/saveForLater/{product}', 'Web\SaveForLaterController@destroy')->name('saveForLater.destroy');
Route::post('/saveForLater/switchToCart/{product}', 'Web\SaveForLaterController@switchToCart')->name('saveForLater.switchToCart');


Route::get('/checkout', 'Web\CheckoutController@index')->name('checkout.index');
Route::post('/checkout', 'Web\CheckoutController@store')->name('checkout.store');


Route::get('/thankyou', 'Web\ConfirmationController@index')->name('confirmation.index');