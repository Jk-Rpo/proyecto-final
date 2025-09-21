@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Recepción</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('receptions.update', $reception) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Paciente</label>
            <select name="patient_id" class="form-control" required>
                <option value="">Seleccione</option>
                @foreach($patients as $patient)
                    <option value="{{ $patient->id }}" {{ $reception->patient_id == $patient->id ? 'selected' : '' }}>
                        {{ $patient->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Observaciones</label>
            <textarea name="observations" class="form-control">{{ $reception->observations }}</textarea>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <input type="text" name="status" class="form-control" value="{{ $reception->status }}" required>
        </div>

        <div class="mb-3">
            <label>CUPS</label>
            <div class="form-check">
                @foreach($cups as $cup)
                    <input class="form-check-input" type="checkbox" name="cups[]" value="{{ $cup->id }}" 
                        id="cup{{ $cup->id }}"
                        {{ $reception->cups->contains($cup->id) ? 'checked' : '' }}>
                    <label class="form-check-label" for="cup{{ $cup->id }}">{{ $cup->name }}</label><br>
                @endforeach
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('receptions.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
