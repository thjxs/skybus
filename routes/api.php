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

Route::middleware('auth:api', 'throttle:3,1')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', 'Auth\\LoginController@login');
Route::post('register', 'Auth\\RegisterController@register');
Route::get('verify', 'Auth\\VerificationController@verify')->name('verification.verify');
Route::get('resend', 'Auth\\VerificationController@resend')->name('verification.resend');

Route::get('login/{platform}', 'Auth\\LoginController@redirectToProvider');
Route::get('login/{platform}/callback', 'Auth\\LoginController@handleProviderCallback');

Route::resources([
    'threads' => 'ThreadController',
]);

Route::post('threads/{thread}/comments', 'CommentController@store');
