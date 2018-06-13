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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
// public endpoint
Route::post('/login','Auth\LoginController@authenticate');
Route::post('/register', 'Auth\RegisterController@register');


Route::middleware('api')->get('/','GalleriesController@index');
Route::middleware('api')->get('/galleries/{id}','GalleriesController@show');
Route::middleware('api')->post('/create','GalleriesController@store');
Route::middleware('api')->put('/edit-gallery/{id}','GalleriesController@update');
Route::middleware('api')->delete('/galleries/{id}','GalleriesController@destroy');
Route::middleware('api')->get('/my-galleries','MyGalleriesController@index');
Route::middleware('api')->get('/authors/{id}','UsersController@show');