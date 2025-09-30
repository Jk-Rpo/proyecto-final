<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientApiController extends Controller
{
    public function index()
    {
        return Patient::paginate(10);
    }

    public function store(Request $request)
    {
          $request->validate([
            'identity_type' => 'required|string|max:50',
            'identity' => 'required|string|max:50',
            'first_name' => 'required|string|max:50',
            'second_name' => 'nullable|string|max:50',
            'first_surname' => 'required|string|max:50',
            'second_surname' => 'nullable|string|max:50',
            'birthdate' => 'required|date',
            'gender' => 'nullable|string|max:20',
            'phone' => 'required|integer|min:0',
            'address' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:100',
        ]);
        $data = $request->all();
        return Patient::create($data);
    }

    public function show(Patient $patient)
    {
        return $patient;
    }

    public function update(Request $request, Patient $patient)
    {
         $data = $request->validate([
            'identity_type' => 'required|string|max:50',
            'identity' => 'required|string|max:50',
            'first_name' => 'required|string|max:50',
            'second_name' => 'nullable|string|max:50',
            'first_surname' => 'required|string|max:50',
            'second_surname' => 'nullable|string|max:50',
            'birthdate' => 'required|date',
            'gender' => 'nullable|string|max:20',
            'phone' => 'required|integer|min:0',
            'address' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:100',
        ]);

        $patient->update($data);
        return $patient;
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();
        return response()->noContent();
    }
    public function searchByDocument($identity)
    {
        $patient = Patient::where('identity', $identity)->first();

        if (!$patient) {
            return response()->json(['message' => 'Paciente no encontrado'], 404);
        }

        return response()->json($patient);
    }
}
