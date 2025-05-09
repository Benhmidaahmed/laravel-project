<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class StudentController extends Controller
{
    public function getStudents(): JsonResponse
{
    try {
        // Charge explicitement toutes les colonnes nécessaires
        $students = Utilisateur::where('roles', 'STUDENT')
            ->select(['id', 'email', 'first_name', 'last_name', 'roles', /* autres champs nécessaires */])
            ->get()
            ->toArray(); // Conversion explicite en tableau

        if(empty($students)) {
            return response()->json([
                'message' => 'Aucun étudiant trouvé',
                'debug' => [
                    'table_exists' => Schema::hasTable('utilisateur'),
                    'student_count' => Utilisateur::where('roles', 'STUDENT')->count()
                ]
            ], 200);
        }

        return response()->json($students);

    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Erreur serveur',
            'details' => env('APP_DEBUG') ? $e->getMessage() : 'Voir les logs',
            'trace' => env('APP_DEBUG') ? $e->getTrace() : null
        ], 500);
    }
}
}
