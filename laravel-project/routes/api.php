<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use App\Http\Controllers\PsychologistController;
use App\Http\Controllers\ForumController;


Route::middleware('api')->prefix('forum')->group(function (){
    // Threads
    Route::post('/threads', [ForumController::class, 'createThread']);
    Route::get('/threads', [ForumController::class, 'getAllThreads']);

    // Posts
    Route::post('/threads/{threadId}/posts', [ForumController::class, 'createPost']);
    Route::get('/threads/{threadId}/posts', [ForumController::class, 'getPostsByThreadId']);

    // Comments
    Route::post('/posts/{postId}/comments', [ForumController::class, 'addComment']);
    Route::get('/posts/{postId}/comments', [ForumController::class, 'getCommentsByPostId']);
});

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

    // Route pour obtenir l'utilisateur connecté
    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });

    // Route des psychologues
    Route::get('/psychologists', [PsychologistController::class, 'index']);
});
