<!DOCTYPE html>
<html lang="es">
  
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> 🌿 SGA 🌿</title>

   @vite(['resources/css/app.css', 'resources/js/app.js'])

@stack('styles')
</head>

<body>
    <div class="app-container d-flex flex-column min-vh-100">

        {{-- Navbar --}}
        @include('layouts.navigation')

        {{-- Header --}}
        @isset($header)
            <header class="app-header">
                <div class="container">
                    <h2>{{ $header }}</h2>
                </div>
            </header>
        @endisset

        {{-- Contenido --}}
        <main class="app-main flex-fill">
            <div class="container">
                <div class="content-card">

                    {{-- Soporta x-app-layout --}}
                    @isset($slot)
                        {{ $slot }}
                    @endisset

                    {{-- Soporta @extends --}}
                    @yield('content')

                </div>
            </div>
        </main>

        {{-- Footer --}}
        <footer class="app-footer">
            © {{ date('Y') }} Sistema Gestión Académico - ITAF
        </footer>

    </div>

</body>
</html>
