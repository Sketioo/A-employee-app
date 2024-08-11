<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;

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

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    //* Resourceful route for employees
    Route::apiResource('employees', EmployeeController::class);

    //* Custom routes
    Route::post('/logout', [AuthController::class, 'logout']);

    //* Custom route for divisions
    Route::get('/divisions', [EmployeeController::class, 'getAllDivisions']);
});

// Route::get('/user', function (Request $request) {
//     return $request->user();
// });
