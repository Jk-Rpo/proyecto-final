@extends('layouts.app') {{-- Usa tu layout base --}}

@section('content')
<div class="container">
    <h1 class="mb-4">Listado de Recepciones</h1>

    {{-- Mensaje de éxito --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Botón para crear nueva recepción --}}
    <a href="{{ route('recepciones.create') }}" class="btn btn-primary mb-3">➕ Nueva Recepción</a>

    {{-- Tabla de recepciones --}}
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Paciente</th>
                <th>CUPS</th>
                <th>Fecha Recepción</th>
                <th>Observaciones</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recepciones as $recepcion)
                <tr>
                    <td>{{ $recepcion->id }}</td>
                    
                    {{-- Paciente --}}
                    <td>
                        @if($recepcion->paciente)
                            {{ $recepcion->paciente->first_name }} {{ $recepcion->paciente->first_surname }}
                        @else
                            <em class="text-muted">Sin paciente</em>
                        @endif
                    </td>
                    
                    {{-- CUPS --}}
                    <td>
                        @if($recepcion->cup)
                            {{ $recepcion->cup->codigo }} - {{ $recepcion->cup->descripcion }}
                        @else
                            <em class="text-muted">Sin CUPS</em>
                        @endif
                    </td>
                    
                    {{-- Fecha --}}
                    <td>{{ $recepcion->fecha_recepcion ?? 'N/A' }}</td>
                    
                    {{-- Observaciones --}}
                    <td>{{ $recepcion->observaciones ?? '—' }}</td>
                    
                    {{-- Acciones --}}
                    <td>
                        <a href="{{ route('recepciones.edit', $recepcion->id) }}" class="btn btn-warning btn-sm">✏️ Editar</a>
                        
                        <form action="{{ route('recepciones.destroy', $recepcion->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('¿Seguro que deseas eliminar esta recepción?')">🗑️ Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">No hay recepciones registradas</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
