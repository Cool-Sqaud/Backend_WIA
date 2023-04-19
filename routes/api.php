<?php

use App\Http\Controllers\StationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MeasurementController;
use App\Http\Controllers\UserController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// User Routes
Route::get('/users', [UserController::class, 'index']);
Route::get('/user', [UserController::class, 'currentUser'])->middleware('auth:api');
Route::get('/user/{id}', [UserController::class, 'show']);
Route::put('/user/{id}/reset', [UserController::class, 'resetPassword']);
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth:api');

// User Routes that need admin priviledge
Route::post('/admin/user', [UserController::class, 'store']);
Route::put('/admin/user/{id}', [UserController::class, 'update']);
Route::delete('/admin/user/{id}', [UserController::class, 'destroy']);
Route::put('/admin/user/{id}/reset', [UserController::class, 'adminPasswordReset']);


// Measurement Routes
Route::get('/test', [MeasurementController::class, 'test']);
Route::get('/measurements', [MeasurementController::class, 'recentIndex']);
Route::get('/measurements/all', [MeasurementController::class, 'index']);
Route::get('/measurement/{stationnumber}', [MeasurementController::class, 'show']);
Route::post('/measurement/add', [MeasurementController::class, 'store']);
Route::post('/measurement/add/multiple', [MeasurementController::class, 'storeMultiple']);

Route::get('/stations', [StationController::class, 'getAllStationsAndLocations']);

