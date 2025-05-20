<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Schema;

class StudentController extends Controller
{
    /**
     * Retrieve all students from the 'utilisateur' table.
     *
     * @return JsonResponse
     */
    public function getStudents(): JsonResponse
    {
        try {
            // Select only necessary columns
            $students = Utilisateur::where('roles', 'STUDENT')
                ->select(['id', 'email', 'first_name', 'last_name', 'roles']) // Add more if needed
                ->get()
                ->toArray();

            if (empty($students)) {
                return response()->json([
                    'message' => 'Aucun étudiant trouvé',
                    'debug' => [
                        'table_exists' => Schema::hasTable('utilisateur'),
                        'student_count' => Utilisateur::where('roles', 'STUDENT')->count(),
                    ]
                ], 200);
            }

            return response()->json($students);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erreur serveur',
                'details' => config('app.debug') ? $e->getMessage() : 'Voir les logs',
                'trace' => config('app.debug') ? $e->getTrace() : null,
            ], 500);
        }
    }
}
