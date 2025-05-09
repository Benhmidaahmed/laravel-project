<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;

// Supprimez le premier prefix('api') et utilisez directement le groupe
Route::middleware('api')->group(function() {
    // Routes d'authentification
    Route::prefix('auth')->group(function () {
        Route::post('/student/register', [AuthController::class, 'registerStudent']);
        Route::post('/psychologist/register', [AuthController::class, 'registerPsychologist']);
        Route::post('/login', [AuthController::class, 'login']);
        Route::get('/confirm', [AuthController::class, 'confirmAccount']);
    });

    // Routes appointments
    Route::post('/appointments', [AppointmentController::class, 'submit']);
    Route::get('/appointments', [AppointmentController::class, 'getAll']);

    // Routes students
    Route::get('/users/students', [StudentController::class, 'getStudents']);

    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });
});
