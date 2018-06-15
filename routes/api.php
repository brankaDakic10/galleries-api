<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| jwt Routes
|--------------------------------------------------------------------------
|
| Here is where you can register jwt routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "jwt" middleware group. Enjoy building your jwt!
|
*/

// Route::middleware('auth:jwt')->get('/user', function (Request $request) {
//     return $request->user();
// });
// public endpoint
Route::post('/login','Auth\LoginController@authenticate');
Route::post('/register', 'Auth\RegisterController@register');


Route::middleware('api')->get('/','GalleriesController@index');
Route::middleware('api')->get('/galleries/{id}','GalleriesController@show');
Route::middleware('jwt')->post('/create','GalleriesController@store');
Route::middleware('jwt')->put('/edit-gallery/{id}','GalleriesController@update');
Route::middleware('jwt')->delete('/galleries/{id}','GalleriesController@destroy');

Route::middleware('jwt')->get('/my-galleries','MyGalleriesController@index');
Route::middleware('api')->get('/authors/{id}','UsersController@show');

Route::middleware('jwt')->post('/galleries/{id}/comments','CommentsController@store')->name('comment');
Route::middleware('jwt')->delete('/comments/{id}','CommentsController@destroy')->name('comment-delete');