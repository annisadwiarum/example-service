<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PositionController;

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post('register', [AuthController::class, "register"]);
    Route::post('login', [AuthController::class, "login"]);
    Route::post('logout', [AuthController::class, "logout"]);
    Route::post('refresh', [AuthController::class, "refresh"]);
    Route::post('me', [AuthController::class, "me"]);

    Route::post('create', [EmployeeController::class, "create"]);
    Route::post('delete_employee', [EmployeeController::class, "delete_employee"]);
    Route::put('edit_employee/{id}', [EmployeeController::class, 'edit_employee']);

    Route::post('create_position', [PositionController::class, 'create_position']);

    Route::post('create_holiday', [HolidayController::class, 'create_holiday']);
});
