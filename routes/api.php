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

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:api');

// Route for CORS
Route::group(['middleware' => 'cors'], function(){

    Route::resource('/users', 'UserController');
    Route::resource('/media', 'MediaController');

    // route for register
    Route::post('/register/{object}', 'UserController@register');

    // confirm e-mail
    Route::get('/confirm_email', 'UserController@confirm_email');

    // route for login
    Route::post('/login/{object}', 'UserController@login');

    // route for contact
    Route::post('/send_email/{object}', 'UserController@send_email');

});
