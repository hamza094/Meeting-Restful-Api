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




Route::group([

    'middleware' => 'api',
    'prefix' => 'v1'

], function ($router) {

    Route::resource('meeting','MeetingController',[
    'except'=>['edit','create']
]);

Route::resource('meeting/registration','RegistrationController',[
    'only'=>['store','destroy']
]);

Route::post('users',[
    'uses'=>'UserController@store'
]);
    
    Route::post('login', 'AuthController@login')->name('login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});

