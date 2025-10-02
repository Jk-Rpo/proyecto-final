<?php 

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Reception;
use App\Http\Resources\ReceptionResource;
use Illuminate\Http\Request;

class ReceptionsApiController extends Controller
{
    public function index(Request $request) {
        if($request->has('identity') && $request->identity !== '' && $request->identity !== null) {
            return Reception::with(['patient','cups'])->whereHas('patient', function($query) use ($request) {
                $query->where('identity', $request->identity);
            })->paginate(10);
        }

        return Reception::with(['patient','cups', 'user'])->paginate(10);
    }

    public function show(Reception $reception) {
        return $reception->load(['patient','cups', 'user']);
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'patient_id'       => 'required|exists:patients,id',
            'observations'     => 'nullable|string',
            'priority'         => 'nullable|string',
            'type_samples'     => 'nullable|string',
            'quantity_samples' => 'nullable|integer',
            'number_case'      => 'nullable|string',
            'type_study'       => 'nullable|string',
            'color'            => 'array|nullable',
            'quantity_plates'  => 'nullable|integer',
            'departure_date'   => 'nullable|date',
            'delivered_to'     => 'nullable|string',
            'institution'      => 'nullable|string',
            'cups'             => 'array|nullable', // IDs de cups //Ejemplo: [{id: 1, quantity: 2}, {id: 2, quantity: 4}, {id: 3, quantity: 1}]
        ]);
        if(!$request->has('status')) {
            $validated['status'] = 'pending';
        }
        if(!$request->has('priority')) {
            $validated['priority'] = 'low';
        }

        if ($request->has('quantity_samples')) {
            $lastId = Reception::whereNotNull('consecutive')->whereDate('created_at', now()->year)->count();
            $validated['consecutive'] = now()->year . '-' . $lastId + 1;
        } else {
            $validated['consecutive'] = null;
        }

        $validated['user_id'] = auth()->user()->id;
        $reception = Reception::create($validated);
        if($request->has('cups')) {
            foreach($request->cups as $cup) {
                $reception->cups()->attach($cup['id'], ['quantity' => $cup['quantity'], 'description' => isset($cup['description']) ? $cup['description'] : null]);
            }
        }
        return $reception->load(['patient','cups','user']);
    }

    public function update(Request $request, Reception $reception) {
        $validated = $request->validate([
            'patient_id'       => 'required|exists:patients,id',
            'observations'     => 'nullable|string',
            'priority'         => 'nullable|string',
            'type_samples'     => 'nullable|string',
            'quantity_samples' => 'nullable|integer',
            'number_case'      => 'nullable|string',
            'type_study'       => 'nullable|string',
            'color'            => 'array|nullable',
            'quantity_plates'  => 'nullable|integer',
            'departure_date'   => 'nullable|date',
            'delivered_to'     => 'nullable|string',
            'institution'      => 'nullable|string',
            'cups'             => 'array|nullable', // IDs de cups //Ejemplo: [{id: 1, quantity: 2}, {id: 2, quantity: 4}, {id: 3, quantity: 1}]
        ]);
        if(!$request->has('status')) {
            $validated['status'] = 'pending';
        }
        if(!$request->has('priority')) {
            $validated['priority'] = 'low';
        }
        
        $reception->update($validated);
        if($request->has('cups')) {
            $reception->cups()->detach();
            foreach($request->cups as $cup) {
                $reception->cups()->attach($cup['id'], ['quantity' => $cup['quantity'], 'description' => isset($cup['description']) ? $cup['description'] : null]);
            }
        }
        return $reception->load(['patient','cups','user']);
    }

    public function destroy(Reception $reception) {
        $reception->cups()->detach();
        $reception->delete();
        return response()->json(['message'=>'Recepción eliminada']);
    }
}
