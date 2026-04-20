@extends('layouts.app')
@push('styles')
@vite('resources/css/admin/boletin/index.css')
@endpush
@section('content')

<div class="container">
    <h2>📊 Boletines por Grado</h2>

    <div class="row">

        @foreach($grades as $grade)

            <div class="col-md-3 mb-3">
                <div class="card shadow">

                    <div class="card-body text-center">

                        <h4>Grado {{ $grade->name }}</h4>

                        <a href="{{ route('admin.boletin.grade',$grade->id) }}"
                           class="btn btn-primary mt-2">
                            Ver estudiantes
                        </a>

                    </div>

                </div>
            </div>

        @endforeach

    </div>
</div>

@endsection