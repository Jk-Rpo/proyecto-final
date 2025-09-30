<?php 

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Reception;
use App\Http\Resources\ReceptionResource;
use Illuminate\Http\Request;

class ReceptionsApiController extends Controller
{
    public function index() {
        return Reception::with(['patient','cups'])->latest()->get();
    }

    public function show(Reception $reception) {
        return $reception->load(['patient','cups']);
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'patient_id'=>'required|exists:patients,id',
            'user_id'=>'required|exists:users,id',
            'status'=>'required|string',
            'observations'=>'nullable|string',
            'cups'=>'array|nullable'
        ]);
        $reception = Reception::create($validated);
        if($request->cups) $reception->cups()->sync($request->cups);
        return $reception->load(['patient','cups']);
    }

    public function update(Request $request, Reception $reception) {
        $validated = $request->validate([
            'patient_id'=>'required|exists:patients,id',
            'user_id'=>'required|exists:users,id',
            'status'=>'required|string',
            'observations'=>'nullable|string',
            'cups'=>'array|nullable'
        ]);
        $reception->update($validated);
        if($request->cups) $reception->cups()->sync($request->cups);
        return $reception->load(['patient','cups']);
    }

    public function destroy(Reception $reception) {
        $reception->cups()->detach();
        $reception->delete();
        return response()->json(['message'=>'Recepción eliminada']);
    }
}
