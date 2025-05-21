<?php

namespace App\Http\Controllers;

use App\Models\utilisateur;
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
        $students = utilisateur::where('roles', 'STUDENT')
            ->select(['id', 'email', 'first_name', 'last_name', 'url_image', 'roles'])
            ->get()
            ->map(function ($student) {
                return [
                    'id' => $student->id,
                    'email' => $student->email,
                    'first_name' => $student->first_name,
                    'last_name' => $student->last_name,
                    'url_image' => $student->url_image,
                    'roles' => $student->roles
                ];
            });

        return response()->json($students);

    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Server error',
            'message' => $e->getMessage()
        ], 500);
    }
}
}
