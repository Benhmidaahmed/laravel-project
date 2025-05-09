<?php
namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AppointmentController extends Controller
{
    public function submit(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'client' => 'required|string',
            'date' => 'required|date',
            'status' => 'required|string',
            'userId' => 'required|integer',
            'email' => 'required|email',
        ]);

        $appointment = new Appointment();
        $appointment->client = $validated['client'];
        $appointment->date = $validated['date'];
        $appointment->status = $request->input('status');
        $appointment->user_id = $request->input('userId');
        $appointment->created_at = now();
        $appointment->updated_at = now();
        $appointment->email = $request->input('email');
        $appointment->save();

        return response()->json(['message' => 'Appointment saved successfully!']);
    }

    public function getAll(): JsonResponse
    {
        $appointments = Appointment::all();
        return response()->json($appointments);
    }
}
