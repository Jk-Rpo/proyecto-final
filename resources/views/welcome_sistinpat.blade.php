<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SISTINPAT - Bienvenido</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-blue-600 to-blue-400 flex items-center justify-center h-screen text-white">

    <div class="text-center">
        <h1 class="text-4xl font-bold mb-6">Bienvenido a <span class="text-yellow-300">SISTINPAT</span></h1>
        <a href="{{ route('menu') }}"
           class="bg-yellow-400 text-blue-900 font-bold px-6 py-3 rounded-lg shadow-lg hover:bg-yellow-300 transition">
            Ingresar
        </a>
    </div>

</body>
</html>
