@extends('layouts.app')

@push('styles')
@vite('resources/css/admin/periods/index.css')
@endpush

@section('content')

<div class="container">

    <h2>Periodos - Año {{ $year->year }}</h2>

    <a href="{{ route('admin.academic_years.index') }}">← Volver</a>

    @php
        $total = $periods->sum('percentage');
    @endphp

    <p>
        Total:
        <strong style="color: {{ $total == 100 ? 'green' : 'red' }}">
            {{ number_format($total,2) }}%
        </strong>
    </p>

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    @if(session('error'))
        <p style="color:red">{{ session('error') }}</p>
    @endif

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Fechas</th>
                    <th>%</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach($periods as $p)
                <tr @if($loop->last) style="background:#eef" @endif>

                    <td data-label="#">
                        {{ $p->number }}
                    </td>

                    <td data-label="Nombre">
                        {{ $p->name }}
                    </td>

                    <td data-label="Fechas">
                        {{ $p->start_date }} - {{ $p->end_date }}
                    </td>

                    <td data-label="%">
                        {{ number_format($p->percentage,2) }}%
                    </td>

                    <td data-label="Estado">
                        {{ $p->status }}
                    </td>

                    <td data-label="Acciones">

                        <a href="{{ route('admin.periods.show',$p->id) }}">Ver</a>

                        <a href="{{ route('admin.periods.edit',$p->id) }}">Editar</a>

                        @if($p->status=='activo')
                            <a href="{{ route('admin.periods.close',$p->id) }}">Cerrar</a>
                        @else
                            <a href="{{ route('admin.periods.open',$p->id) }}">Activar</a>
                        @endif

                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

@endsection