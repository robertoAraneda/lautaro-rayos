<?php

use Illuminate\Http\Request;
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
Route::group([
  'prefix' => 'auth'
], function () {
    Route::post('login', [App\Http\Controllers\AuthController::class, 'login']);

    Route::group([
    'middleware' => 'auth:api'
  ], function () {
      Route::get('user', [App\Http\Controllers\AuthController::class, 'user']);
      Route::get('logout', 'AuthController@logout');
  });
});


Route::group([
  'prefix' => 'v1',
  'middleware' => 'auth:api'
], function () {
    //funcionarios
    Route::post('/signup', [App\Http\Controllers\AuthController::class, 'signup']);
    Route::get('/users', [App\Http\Controllers\UserController::class, 'index']);
    Route::put('/users/{id}', [App\Http\Controllers\UserController::class, 'update']);
    Route::delete('/users/{id}', [App\Http\Controllers\UserController::class, 'destroy']);

    //tipos de reporte
    Route::post('/type-reports', [App\Http\Controllers\TypeReportController::class, 'store']);
    Route::get('/type-reports', [App\Http\Controllers\TypeReportController::class, 'index']);
    Route::put('/type-reports/{id}', [App\Http\Controllers\TypeReportController::class, 'update']);
    Route::delete('/type-reports/{id}', [App\Http\Controllers\TypeReportController::class, 'destroy']);

    //patient
    Route::post('/patients', [App\Http\Controllers\PatientController::class, 'store']);
    Route::put('/patients/{id}', [App\Http\Controllers\PatientController::class, 'update']);
    Route::delete('/patients{id}', [App\Http\Controllers\PatientController::class, 'destroy']);
    Route::get('/patients/find/rut/{rut}', [App\Http\Controllers\PatientController::class, 'findByRut']);
    Route::get('/patients/find/bdup/{bdup}', [App\Http\Controllers\PatientController::class, 'findByBdup']);
    Route::post('/patients/find/demographics', [App\Http\Controllers\PatientController::class, 'findPatientByDemographics']);
});
