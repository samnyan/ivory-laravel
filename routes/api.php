<?php

use Illuminate\Support\Facades\Route;

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

// Api endpoint for public request without authentication

// Api endpoint for authentication
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});

// Api endpoint for Doctor
Route::group([
    'middleware' => ['api', 'auth:api', 'type:0'],
    'prefix' => 'doctor'
], function () {
    Route::get('me', 'DoctorController@me');
    Route::get('certificate', 'DoctorController@getCertificate');
    Route::post('certificate/upload', 'DoctorController@uploadCertificate');
});

// Api endpoint for Professor
Route::group([
    'middleware' => ['api', 'auth:api', 'type:2'],
    'prefix' => 'professor'
], function () {
    Route::get('/', function () {
        return response()->json(['message' => 'Hi']);
    });
});

// Api endpoint for Professor
Route::group([
    'middleware' => ['api', 'auth:api', 'type:3'],
    'prefix' => 'management'
], function () {
    Route::get('/', function () {
        return response()->json(['message' => 'Hi']);
    });
});
