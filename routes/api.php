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
    Route::resource('/audio', 'AudioController');
    Route::resource('/video', 'VideoController');

    // Route for register
    Route::post('/register/{object}', 'UserController@register');

    // Route for e-mail confirmation
    Route::get('/confirm_email', 'UserController@confirm_email');

    // Route for login
    Route::post('/login/{object}', 'UserController@login');

    // Route for contact
    Route::post('/send_email/{object}', 'UserController@send_email');

    // Route for get audio "for change" data
    Route::get('/audio_for_change', 'AudioController@audio_for_change');

    // Route for get video "for change" data
    Route::get('/video_for_change', 'VideoController@video_for_change');

    // Route for collect audio "allowed" data
    Route::post('/audio_allowed/{user_id}', 'AudioController@audio_allowed');

    // Route for collect video "allowed" data
    Route::post('/video_allowed/{user_id}', 'VideoController@video_allowed');

    // Route for collect audio "personal" data
    Route::post('/audio_personal/{user_id}', 'AudioController@audio_personal');

    // Route for collect video "personal" data
    Route::post('/video_personal/{user_id}', 'VideoController@video_personal');

});
