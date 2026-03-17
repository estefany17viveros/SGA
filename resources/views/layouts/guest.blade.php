<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>🌿 SGA - Sistema de Gestión Académica 🌿</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="login-page font-sans antialiased">

    <div class="login-wrapper">

        <!-- Panel del Logo -->
        <div class="login-logo">
            <img src="{{ asset('images/logo-itaf.jpg') }}" alt="Logo SGA">
        </div>

        <!-- Card del Login -->
        <div class="login-card">
            {{ $slot }}
        </div>

    </div>

</body>
</html>