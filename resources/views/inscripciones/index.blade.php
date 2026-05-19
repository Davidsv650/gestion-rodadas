@extends('layouts.app')
@section('content')

@php
    $esAdmin = auth()->user()->rol === 'admin';
@endphp

<div class="container mt-4">

    {{-- MENSAJE --}}
    @if(Session::has('mensaje'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ Session::get('mensaje') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

   <div class="d-flex justify-content-between align-items-center mb-4">

    <h1>
        {{ $esAdmin ? 'Todas las inscripciones' : 'Mis inscripciones' }}
    </h1>

    @if($esAdmin)

    <a href="{{ url('inscripciones/create') }}"
       class="btn btn-primary">

        <i class="bi bi-plus-circle"></i>
        Crear Nueva Inscripción

    </a>

    @endif

</div>
    {{-- TABLA --}}
    <div class="table-responsive">
        <table class="table table-hover align-middle">

            <thead class="table-dark">
                <tr>
                    <th>Usuario</th>
                    <th>Rodada</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    @if($esAdmin)
                        <th class="text-end">Acciones</th>
                    @endif
                </tr>
            </thead>

            <tbody>
                @forelse ($inscripciones as $inscripcion)
                <tr>

                    {{-- USUARIO --}}
                    <td>
                        {{ optional($inscripcion->usuario)->nombre ?? 'Sin usuario' }}
                    </td>

                    {{-- RODADA --}}
                    <td>
                        {{ optional($inscripcion->rodada)->titulo ?? 'Sin rodada' }}
                    </td>

                    {{-- FECHA --}}
                    <td>
                        {{ \Carbon\Carbon::parse($inscripcion->fecha)->format('d-m-Y') }}
                    </td>

                    {{-- ESTADO --}}
                    <td>
                        <span class="badge bg-success">
                            {{ $inscripcion->estado }}
                        </span>
                    </td>

                    {{-- ACCIONES ADMIN --}}
                    @if($esAdmin)
                    <td class="text-end">

                        <a href="{{ url('/inscripciones/' . $inscripcion->id . '/edit') }}"
                           class="btn btn-sm btn-success">
                            Editar
                        </a>

                        
                                   <form action="{{ url('/inscripciones/' . $inscripcion->id)}}"
      method="POST"
      class="d-inline delete-form"
      data-name= 'Inscripción'>

    @csrf
    {{ method_field('DELETE')}}

    <input type="submit"
           value="Borrar"
           class="btn btn-danger">
</form>

                    </td>
                    @endif

                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">
                        No hay inscripciones
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>
    </div>

   

 

</div>

@endsection