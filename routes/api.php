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

Route::get('files/{group}/{file}', function ($group, $file) {
    return Storage::download($group.'/'.$file);
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
    Route::post('certificate/upload', 'DoctorController@uploadCertificate');
    Route::get('clinic', 'DoctorController@getClinic');
    Route::post('clinic', 'DoctorController@createClinic');
    Route::post('clinic/image', 'DoctorController@uploadClinicImage');
    Route::get('patient', 'DoctorController@getPatients');
    Route::get('patient/{id}', 'DoctorController@getPatient');
    Route::post('patient', 'DoctorController@createPatient');
    Route::post('patient/{id}', 'DoctorController@updatePatient');
    Route::post('patient/{id}/photo', 'DoctorController@uploadPatientPhoto');
    Route::get('patientCase', 'DoctorController@getCases');
    Route::get('patientCase/{id}', 'DoctorController@getCase');
    Route::post('patientCase', 'DoctorController@createCase');
    Route::post('patientCase/{id}', 'DoctorController@updateCase');
    Route::delete('patientCase/{id}', 'DoctorController@deleteCase');
    Route::post('patientCaseFile', 'DoctorController@uploadCaseFile');
    Route::get('order', 'DoctorController@getOrders');
    Route::get('order/{id}', 'DoctorController@getOrder');
    Route::post('order', 'DoctorController@createOrder');
    Route::post('order/{id}', 'DoctorController@updateOrder');
    Route::post('order/{id}/detail', 'DoctorController@createOrderDetail');
    Route::post('order/{id}/{detailId}', 'DoctorController@updateOrderDetail');
    Route::delete('order/{id}/{detailId}', 'DoctorController@deleteOrderDetail');
});

// Api endpoint for Professor
Route::group([
    'middleware' => ['api', 'auth:api', 'type:2'],
    'prefix' => 'professor'
], function () {
    Route::get('patientCase', 'ProfessorController@getPatientCases');
    Route::get('patientCase/{id}', 'ProfessorController@getPatientCase');
    Route::post('patientCase/{id}', 'ProfessorController@updatePatientCase');
    Route::get('order', 'ProfessorController@getOrders');
    Route::get('order/{id}', 'ProfessorController@getOrder');
    Route::post('order/{id}', 'ProfessorController@updateOrder');
    Route::post('order/{id}/detail', 'ProfessorController@createOrderDetail');
    Route::post('order/{id}/{detailId}', 'ProfessorController@updateOrderDetail');
    Route::delete('order/{id}/{detailId}', 'ProfessorController@deleteOrderDetail');
    Route::get('doctor', 'ProfessorController@getDoctors');
    Route::get('doctor/{id}', 'ProfessorController@getDoctor');
    Route::post('doctor/{id}', 'ProfessorController@setDoctor');
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

Route::any('/{any}', function () {
    return response()->json(['message' => '404 Not Found. 不存在的路径'], 404);
})->where('any', '.*');
