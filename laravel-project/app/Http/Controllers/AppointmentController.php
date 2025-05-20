<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AppointmentController extends Controller
{
    /**
     * Store a new appointment.
     */
    public function submit(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'client' => 'required|string',
            'date' => 'required|date',
            'status' => 'required|string',
            'userId' => 'required|integer',
            'email' => 'required|email',
        ]);

        $appointment = Appointment::create([
            'client' => $validated['client'],
            'date' => $validated['date'],
            'status' => $validated['status'],
            'user_id' => $validated['userId'],
            'email' => $validated['email'],
        ]);

        return response()->json([
            'message' => 'Appointment saved successfully!',
            'appointment' => $appointment,
        ], 201);
    }

    /**
     * Retrieve all appointments.
     */
    public function getAll(): JsonResponse
    {
        $appointments = Appointment::all();
        return response()->json($appointments);
    }
}
