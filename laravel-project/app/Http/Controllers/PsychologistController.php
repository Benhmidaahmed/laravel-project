<?php

namespace App\Http\Controllers;

use App\Models\utilisateur;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PsychologistController extends Controller
{
    /**
     * Retrieve a list of psychologists.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $query = utilisateur::select([
                'id',
                'first_name',
                'last_name',
                'specialization',
                'url_image',
            ])
            ->where('roles', 'PSYCHOLOGIST');

        // Optional filtering by name or specialization
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%$search%")
                  ->orWhere('last_name', 'like', "%$search%")
                  ->orWhere('specialization', 'like', "%$search%");
            });
        }

        $psychologists = $query->get();

        return response()->json($psychologists);
    }
}
