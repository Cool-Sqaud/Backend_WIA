<?php

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

Route::get('/users', [UserController::class, 'index']);
Route::get('/user', [UserController::class, 'user'])->middleware('auth:api');
Route::get('/test', [MeasurementController::class, 'test']);
Route::get('/measurements', [MeasurementController::class, 'index']);
Route::post('/measurement/add', [MeasurementController::class, 'store']);
Route::post('/measurement/add/multiple', [MeasurementController::class, 'storeMultiple']);
