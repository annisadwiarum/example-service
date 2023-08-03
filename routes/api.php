<?php

use App\Models\Precense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;

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

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post('register', [AuthController::class, "register"]);
    Route::post('login', [AuthController::class, "login"]);
    Route::post('logout', [AuthController::class, "logout"]);
    Route::post('refresh', [AuthController::class, "refresh"]);
    Route::post('me', [AuthController::class, "me"]);

    Route::post('create', [EmployeeController::class, "create"]);
    Route::post('delete_employee', [EmployeeController::class, "delete_employee"]);
    Route::get('edit_employee', [EmployeeController::class, "edit_employee"]);
    Route::post('tokenEmployee', [EmployeeController::class, "tokenEmployee"]);
});
