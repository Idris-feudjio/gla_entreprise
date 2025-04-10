<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    Route::apiResource('students', StudentController::class);
    Route::apiResource('teachers', TeacherController::class);
    Route::apiResource('rooms', RoomController::class);
    Route::apiResource('subjects', SubjectController::class);
    Route::apiResource('sessions', SessionController::class);
    Route::apiResource('attendances', AttendanceController::class);

    Route::get('/sessions/{session}/attendances', [AttendanceController::class, 'getBySession']);
    Route::get('/sessions/{session}/teacher', [SessionController::class, 'getTeacher']);
    Route::get('/students/{student}/absences-by-subject', [AttendanceController::class, 'getAbsencesBySubject']);
});
