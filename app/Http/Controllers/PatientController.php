<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patients = Patient::all();
        return view('patients', compact('patients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('patients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
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

        Patient::create($request->all());
            
        return back()->with('success', '✅ Paciente guardado exitosamente.');
    }
    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        return view('patients.show', compact('patient'));        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Paciente $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Patient $patient)
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

        $patient->update($request->all());
            
        return back()->with('success', '✅ Paciente actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        $patient->delete();
        return back()->with('success', '✅ Paciente eliminado exitosamente.');
    }
}
