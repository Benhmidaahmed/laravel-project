<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use App\Http\Controllers\PsychologistController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\MessageController;



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


// Route::middleware(['auth:api', 'role:PSYCHOLOGIST'])->group(function () {
//     Route::get('/psychologists', function () {
//         return response()->json(['message' => 'Psychologist Dashboard']);
//     });
// });

// Route::middleware(['auth:api', 'role:STUDENT'])->group(function () {
//     Route::get('/users/students', function () {
//         return response()->json(['message' => 'Student Dashboard']);
//     });
// });
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:api')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('me', [AuthController::class, 'me']);
});

    // Routes appointments
    Route::post('/appointments', [AppointmentController::class, 'submit']);
    Route::get('/appointments', [AppointmentController::class, 'getAll']);

    Route::post('/messages/send', [MessageController::class, 'sendMessage']);
Route::post('/messages/conversation', [MessageController::class, 'getConversation']);

    // Routes students
    Route::get('/users/students', [StudentController::class, 'getStudents']);

    // Route pour obtenir l'utilisateur connecté
    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });

// Route des psychologues
Route::get('/psychologists', [PsychologistController::class, 'index']);
