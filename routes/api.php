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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
// Get list of Products
Route::group(['namespace' => 'admin', 'prefix' => 'product'], function(){
    Route::get('products','ProductController@index')->name('products');

    // Get specific Product
    Route::get('product/{id}','ProductController@show');
    
    // Delete a Product
    Route::delete('product/{id}','ProductController@destroy');
    
    // Update existing Product
    Route::put('product/{id}','ProductController@update');
    
    // Create new Product
    Route::post('product','ProductController@store');
    // Create new Product
    Route::put('productlike/{id}','ProductController@updateLikeStatus');
});
Route::group(['namespace' => 'order'], function(){
    Route::get('orders', 'OrderController@show');
    Route::post('orders', 'OrderController@store');
});
Route::post('auth/register', 'UserController@register');
Route::post('auth/login', 'UserController@login');
Route::group(['middleware' => 'jwt.auth'], function () {
Route::get('user-info', 'UserController@getUserInfo');
Route::get('category','CategoryController@index');
});