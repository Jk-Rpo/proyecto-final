@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Recepciones</h1>
    <a href="{{ route('receptions.create') }}" class="btn btn-primary mb-3">Crear Nueva Recepción</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Paciente</th>
                <th>Observaciones</th>
                <th>Status</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($receptions as $reception)
                <tr>
                    <td>{{ $reception->id }}</td>
                    <td>{{ $reception->patient->name ?? 'Sin paciente' }}</td>
                    <td>{{ $reception->observations }}</td>
                    <td>{{ $reception->status }}</td>
                    <td>
                        <a href="{{ route('receptions.show', $reception) }}" class="btn btn-info btn-sm">Ver</a>
                        <a href="{{ route('receptions.edit', $reception) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('receptions.destroy', $reception) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar esta recepción?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $receptions->links() }}
</div>
@endsection
