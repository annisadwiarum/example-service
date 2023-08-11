<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\EmployeedController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\PresenceController;

Route::post('create_position', [PositionController::class, 'create_position']);
Route::get('position', [PositionController::class, 'get_positions']);

Route::get('role', [RoleController::class, 'get_roles']);

Route::middleware('auth:api')->prefix('/auth')->group(function ($router) {
    Route::post('/register', [AuthController::class, "register"]);
    Route::post('/login', [AuthController::class, "login"]);
    Route::post('/logout', [AuthController::class, "logout"]);
    Route::post('/refresh', [AuthController::class, "refresh"]);
    Route::post('/me', [AuthController::class, "me"]);

    Route::post('/create', [EmployeeController::class, "create"]);
    Route::post('/delete_employee', [EmployeeController::class, "delete_employee"]);
    Route::put('/edit_employee/{id}', [EmployeeController::class, 'edit_employee']);

    Route::post('/create_holiday', [HolidayController::class, 'create_holiday']);

    Route::post('/create_attendance', [AttendanceController::class, 'create_attendance']);

    Route::post('/send_presence', [PresenceController::class, 'send_presence']);

    Route::post('/add_employeed', [EmployeedController::class, 'add_employeed']);
    Route::post('/delete_employeed', [EmployeedController::class, "delete_employeed"]);
    Route::post('/edit_employeed/{id}', [EmployeedController::class, 'edit_employeed']);
});
