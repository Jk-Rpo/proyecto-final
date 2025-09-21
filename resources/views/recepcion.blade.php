@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <!-- Título -->
    <h2 class="text-2xl font-bold mb-6 text-center">Formulario de Recepción de Pacientes</h2>

    <!-- Mensaje de éxito -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Formulario -->
    <form action="{{ route('recepcion.store') }}" method="POST" class="bg-gray-100 p-6 rounded shadow-md space-y-4">
        @csrf

        <div class="grid grid-cols-2 gap-4">
            <!-- Tipo de Documento -->
            <div>
                <label class="font-semibold">Tipo de Documento</label>
                <select name="identity_type" class="w-full border px-3 py-2 rounded" required>
                    <option value="">-- Seleccione --</option>
                    <option value="C.C.">Cédula de Ciudadanía (C.C.)</option>
                    <option value="C.E.">Cédula de Extranjería (C.E.)</option>
                    <option value="T.I.">Tarjeta de Identidad (T.I.)</option>
                    <option value="P.A.">Pasaporte (P.A.)</option>
                </select>
            </div>

            <!-- Número de Documento -->
            <div>
                <label class="font-semibold">Número de Documento</label>
                <input type="text" name="identity" class="w-full border px-3 py-2 rounded" required>
            </div>

            <!-- Primer Nombre -->
            <div>
                <label class="font-semibold">Primer Nombre</label>
                <input type="text" name="first_name" class="w-full border px-3 py-2 rounded" required>
            </div>

            <!-- Segundo Nombre -->
            <div>
                <label class="font-semibold">Segundo Nombre</label>
                <input type="text" name="second_name" class="w-full border px-3 py-2 rounded">
            </div>

            <!-- Primer Apellido -->
            <div>
                <label class="font-semibold">Primer Apellido</label>
                <input type="text" name="first_surname" class="w-full border px-3 py-2 rounded" required>
            </div>

            <!-- Segundo Apellido -->
            <div>
                <label class="font-semibold">Segundo Apellido</label>
                <input type="text" name="second_surname" class="w-full border px-3 py-2 rounded">
            </div>

            <!-- Edad -->
            <div>
                <label class="font-semibold">Edad</label>
                <input type="number" name="Edad" class="w-full border px-3 py-2 rounded" required>
            </div>

            <!-- Teléfono -->
            <div>
                <label class="font-semibold">Número de Teléfono</label>
                <input type="text" name="phone" class="w-full border px-3 py-2 rounded">
            </div>
        </div>

        <!-- Dirección -->
        <div>
            <label class="font-semibold">Dirección de Residencia</label>
            <input type="text" name="address" class="w-full border px-3 py-2 rounded">
        </div>

        <!-- Email -->
        <div>
            <label class="font-semibold">Email</label>
            <input type="email" name="Email" class="w-full border px-3 py-2 rounded">
        </div>

        <!-- Institución que Remite -->
        <div>
            <label class="font-semibold">Institución que Remite</label>
            <select name="institution" class="w-full border px-3 py-2 rounded">
                <option value="">-- Seleccione --</option>
                <option value="HAMA">HAMA (Hospital Alma Mater de Antioquia)</option>
                <option value="HUSVF">HUSVF (Hospital San Vicente Fundación)</option>
                <option value="HUSVF-R">HUSVF-R (Hospital San Vicente Fundación-Rionegro)</option>
                <option value="CES">Clínica CES</option>
                <option value="HPTU">HPTU (Hospital Pablo Tobón Uribe)</option>
                <option value="Somer">Clínica Somer</option>
                <option value="Cardio VID">Cardio VID</option>
                <option value="Particular">Particular</option>
            </select>
        </div>

        <!-- Tipo de Muestra y Cantidad -->
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="font-semibold">Tipo de Muestra</label>
                <input type="text" name="type_samples" class="w-full border px-3 py-2 rounded">
            </div>

            <div>
                <label class="font-semibold">Cantidad de Muestras</label>
                <input type="number" name="quantity_samples" class="w-full border px-3 py-2 rounded">
            </div>
        </div>

        <!-- CUPS -->
        <div>
            <label class="font-semibold">CUPS</label>
            <select name="cups_id" class="w-full border px-3 py-2 rounded" required>
                <option value="">-- Seleccione un CUPS --</option>
                @foreach($cups as $cup)
                    <option value="{{ $cup->id }}">{{ $cup->codigo }} - {{ $cup->descripcion }}</option>
                @endforeach
            </select>
        </div>

        <!-- Botones -->
        <div class="flex gap-4 mt-4">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                Guardar
            </button>

            <a href="{{ route('menu') }}" class="bg-gray-600 text-white px-6 py-2 rounded hover:bg-gray-700 transition">
                Regresar
            </a>
        </div>
    </form>
</div>
@endsection
