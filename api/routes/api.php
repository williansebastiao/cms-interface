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


Route::group(['middleware' => 'device'], function() {
    Route::get('categories', 'CategoryController@list');
    Route::get('books', 'BookController@list');
    Route::get('books/recent', 'BookController@recent');
    Route::get('books/popular', 'BookController@popular');
    Route::get('books/{id}', 'BookController@detail');
    Route::get('books/{id}/content', 'BookController@content');
    
    Route::post('payment/{device_id}/unlock_book', 'PaymentController@unlock');
    Route::post('payment/{device_id}/restore', 'PaymentController@restore');
    
    Route::post('favorites/{book_id}/add_to_library', 'FavoriteBookController@addToLibrary');
    Route::delete('favorites/{book_id}/remove_from_library', 'FavoriteBookController@deleteFromLibrary');
});

Route::post('login', 'AuthController@login');

Route::group(['middleware' => 'auth:api', 'prefix' => 'admin'], function() {
    Route::get('users', 'UserController@list');
    Route::post('users', 'UserController@create');
    Route::delete('users/{id}', 'UserController@delete');

    Route::get('categories', 'CategoryController@listAdmin');
    Route::post('categories', 'CategoryController@create');

    Route::get('books', 'BookController@listAdmin');
    Route::get('books/{id}', 'BookController@detailAdmin');
    Route::delete('books/{id}', 'BookController@delete');
    Route::post('books', 'BookController@create');
    Route::put('books/{id}', 'BookController@update');
});


