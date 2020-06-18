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
Route::group([
    'middleware' => 'api',
    'prefix' => 'open'
], function () {
    Route::get('clinic', 'ClinicController@getClinics');
    Route::get('clinic/{id}', 'ClinicController@getClinic');
});

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
    Route::get('certificate', 'DoctorController@getCertificate');
    Route::post('certificate/upload', 'DoctorController@uploadCertificate');
    Route::get('clinic', 'DoctorController@getClinic');
    Route::get('patient', 'DoctorController@getPatients');
    Route::get('patient/{id}', 'DoctorController@getPatient');
    Route::post('patient', 'DoctorController@createPatient');
    Route::put('patient', 'DoctorController@updatePatient');
    Route::get('patientCase', 'DoctorController@getCases');
    Route::get('patientCase/{id}', 'DoctorController@getCase');
    Route::get('order', 'DoctorController@getOrders');
    Route::get('order/{id}', 'DoctorController@getOrder');
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

// Api endpoint for Manager
Route::group([
    'middleware' => ['api', 'auth:api', 'type:3'],
    'prefix' => 'management'
], function () {
    Route::get('/user', 'ManagementController@getUsers');
    Route::get('/user/{id}', 'ManagementController@getUser');
    Route::get('/clinic', 'ManagementController@getClinics');
    Route::get('/clinic/{id}', 'ManagementController@getClinic');
    Route::get('/order', 'ManagementController@getOrders');
    Route::get('/order/{id}', 'ManagementController@getOrder');
});
