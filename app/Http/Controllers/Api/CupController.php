<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CupResource;
use App\Models\Cup;
use Illuminate\Http\Request;

class CupController extends Controller
{
    public function index()
    {
        return CupResource::collection(Cup::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code'        => 'required|string|max:50|unique:cups,code',
            'description' => 'nullable|string',
        ]);

        $cup = Cup::create($validated);

        return new CupResource($cup);
    }

    public function show(Cup $cup)
    {
        return new CupResource($cup->load('receptions'));
    }

    public function update(Request $request, Cup $cup)
    {
        $validated = $request->validate([
            'code'        => 'sometimes|string|max:50|unique:cups,code,' . $cup->id,
            'description' => 'nullable|string',
        ]);

        $cup->update($validated);

        return new CupResource($cup);
    }

    public function destroy(Cup $cup)
    {
        $cup->delete();

        return response()->json(['message' => 'Cup deleted successfully']);
    }
}
