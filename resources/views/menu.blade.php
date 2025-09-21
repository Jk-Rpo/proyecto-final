<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SISTINPAT - Menú</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="bg-white p-10 rounded-2xl shadow-xl w-full max-w-md text-center">
        <h2 class="text-2xl font-bold mb-8 text-blue-700">Menú Principal</h2>

        <div class="grid gap-4">
            <a href="{{ route('recepcion.index') }}"
               class="block bg-gray-600 text-white py-3 rounded-lg font-semibold hover:bg-green-700 transition">
                Recepción
            </a>

            <a href="#"
               class="block bg-gray-600 text-white py-3 rounded-lg font-semibold hover:bg-green-700 transition">
                Procesamiento
            </a>

            <a href="#"
               class="block bg-gray-600 text-white py-3 rounded-lg font-semibold hover:bg-green-700 transition">
                Patólogos
            </a>

            <a href="#"
               class="block bg-gray-600 text-white py-3 rounded-lg font-semibold hover:bg-green-700 transition">
                Resultados
            </a>

            <a href="#"
               class="block bg-purple-600 text-white py-3 rounded-lg font-semibold hover:bg-green-700 transition">
                Facturación
            </a>

            <a href="#"
               class="block bg-blue-700 text-white py-3 rounded-lg font-semibold hover:bg-green-800 transition">
                Dashboard
            </a>
        </div>
    </div>

</body>
</html>
