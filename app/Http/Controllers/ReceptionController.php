<?php

namespace App\Http\Controllers;

use App\Models\Reception;
use App\Models\Cup;
use App\Models\Patient;
use Illuminate\Http\Request;

class ReceptionController extends Controller
{
    /**
     * Muestra listado de recepciones
     */
    public function index()
    {
        $receptions = Reception::with(['patient', 'cups'])->latest()->paginate(10);
        return view('receptions.index', compact('receptions'));
    }

    /**
     * Formulario de creación
     */
    public function create()
    {
        $patients = Patient::all();
        $cups = Cup::all();
        return view('receptions.create', compact('patients', 'cups'));
    }

    /**
     * Guardar en la BD
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id'       => 'required|exists:patients,id',
            'observations'     => 'nullable|string',
            'status'           => 'required|string',
            'priority'         => 'nullable|string',
            'type_samples'     => 'nullable|string',
            'consecutive'      => 'nullable|integer',
            'quantity_samples' => 'nullable|integer',
            'number_case'      => 'nullable|string',
            'type_study'       => 'nullable|string',
            'color'            => 'nullable|string',
            'quantity_plates'  => 'nullable|integer',
            'departure_date'   => 'nullable|date',
            'delivered_to'     => 'nullable|string',
            'cups'             => 'array|nullable', // IDs de cups
        ]);

        $auth = $request->user();
        $validated['user_id'] = $auth->id;

        $reception = Reception::create($validated);

        if ($request->has('cups')) {
            $reception->cups()->sync($request->cups);
        }

        return redirect()->route('receptions.index')->with('success', 'Recepción creada correctamente.');
    }

    /**
     * Ver detalle
     */
    public function show(Reception $reception)
    {
        $reception->load(['patient', 'cups']);
        return view('receptions.show', compact('reception'));
    }

    /**
     * Formulario de edición
     */
    public function edit(Reception $reception)
    {
        $patients = Patient::all();
        $cups = Cup::all();
        $reception->load('cups');
        return view('receptions.edit', compact('reception', 'patients', 'cups'));
    }

    /**
     * Actualizar BD
     */
    public function update(Request $request, Reception $reception)
    {
        $validated = $request->validate([
            'patient_id'       => 'required|exists:patients,id',
            'observations'     => 'nullable|string',
            'status'           => 'required|string',
            'priority'         => 'nullable|string',
            'type_samples'     => 'nullable|string',
            'consecutive'      => 'nullable|integer',
            'quantity_samples' => 'nullable|integer',
            'number_case'      => 'nullable|string',
            'type_study'       => 'nullable|string',
            'color'            => 'nullable|string',
            'quantity_plates'  => 'nullable|integer',
            'departure_date'   => 'nullable|date',
            'delivered_to'     => 'nullable|string',
            'cups'             => 'array|nullable',
        ]);

        $reception->update($validated);

        if ($request->has('cups')) {
            $reception->cups()->sync($request->cups);
        }

        return redirect()->route('receptions.index')->with('success', 'Recepción actualizada correctamente.');
    }

    /**
     * Eliminar recepción
     */
    public function destroy(Reception $reception)
    {
        $reception->cups()->detach();
        $reception->delete();

        return redirect()->route('receptions.index')->with('success', 'Recepción eliminada correctamente.');
    }
}
