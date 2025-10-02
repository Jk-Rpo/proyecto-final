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
        return view('receptions.index');
    }

    /**
     * Formulario de creación
     */
    public function create()
    {
        return view('receptions.create');
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
        $reception->load('cups');
        return view('receptions.edit', compact('reception'));
    }

    public function createPatient()
    {
        return view('receptions.createPatient');
    }

    public function createSpecial()
    {
        return view('receptions.createSpecial');
    }
}
