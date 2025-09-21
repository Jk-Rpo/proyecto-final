@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalle Recepción #{{ $reception->id }}</h1>

    <p><strong>Paciente:</strong> {{ $reception->patient->name ?? 'Sin paciente' }}</p>
    <p><strong>CUS:</strong> {{ $reception-> }}</p>
    <p><strong>Observaciones:</strong> {{ $reception->observations }}</p>
    <p><strong>Status:</strong> {{ $reception->status }}</p>
    <p><strong>CUPS:</strong> 
        @foreach($reception->cups as $cup)
            {{ $cup->name }}{{ !$loop->last ? ',' : '' }}
        @endforeach
    </p>

    <a href="{{ route('receptions.index') }}" class="btn btn-secondary">Volver</a>
</div>
@endsection
