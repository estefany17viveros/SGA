@push('styles')
    @vite('resources/css/app.css')

<h2>Enlace de recuperación</h2>

<p>Copia este enlace:</p>

<a href="{{ $link }}">{{ $link }}</a>