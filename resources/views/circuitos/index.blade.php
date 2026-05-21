@extends('layouts.app')

@section('content')

@php
    $esAdmin = auth()->user()->rol === 'admin';
@endphp

@if(Session::has('mensaje'))

<div class="alert alert-success alert-dismissible fade show" role="alert">

    {{ Session::get('mensaje')}}

    <button type="button"
            class="btn-close"
            data-bs-dismiss="alert">
    </button>

</div>

@endif

<div class="container mt-4">

    {{-- CABECERA --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1>Circuitos</h1>

        @if($esAdmin)

        <a href="{{ url('circuitos/create') }}"
           class="btn btn-primary">

            <i class="bi bi-plus-circle"></i>
            Crear Nuevo Circuito

        </a>

        @endif

    </div>

    {{-- BUSCADOR --}}
    <div class="row mb-4">

        <form action="{{ route('circuitos.index') }}"
              method="GET"
              class="col-12">

            <div class="input-group">

                <input type="text"
                       class="form-control"
                       name="buscar"
                       placeholder="Buscar por nombre"
                       value="{{ $buscar ?? '' }}">

                <button class="btn btn-primary"
                        type="submit">

                    <i class="bi bi-search"></i>
                    Buscar

                </button>

            </div>

        </form>

    </div>

    {{-- GRID DE CIRCUITOS --}}
    <div class="row">

        @forelse ($circuitos as $circuito)

        <div class="col-md-4 mb-4">

            <div class="card h-100 shadow-sm card-hover">

                {{-- IMAGEN --}}
                @if($circuito->imagen)

                <div class="p-3 bg-light d-flex justify-content-center align-items-center img-container">

                    <img src="{{ asset($circuito->imagen) }}"
                         class="img-circuito">

                </div>

                @endif

                {{-- BODY --}}
                <div class="card-body d-flex flex-column">

                    <h5 class="card-title">

                        {{ $circuito->nombre }}

                    </h5>

                    <p class="card-text">

                        <strong>📍 Ubicación:</strong>
                        {{ $circuito->ubicacion }}<br>

                        <strong>📏 Longitud:</strong>
                        {{ $circuito->longitud }} km<br>

                        <strong>↪️ Curvas:</strong>
                        {{ $circuito->numero_de_curvas }}<br><br>

                        {{ $circuito->descripcion }}

                    </p>

                    {{-- RODADAS --}}
                    @if($circuito->rodadas->count() > 0)

                    <p><strong>🏁 Rodadas:</strong></p>

                    <ul>

                        @foreach($circuito->rodadas as $rodada)

                        <li>

                            {{ $rodada->titulo }}

                            -

                            <a href="{{ url('/calendario') }}">
                                Ver calendario
                            </a>

                        </li>

                        @endforeach

                    </ul>

                    @endif

                    {{-- BOTONES --}}
                    <div class="mt-auto">

                        @if($esAdmin)

                        <a href="{{ url('/circuitos/' . $circuito->id . '/edit') }}"
                           class="btn btn-success btn-sm me-1">

                            <i class="bi bi-pencil"></i>

                        </a>

                        <form action="{{ url('/circuitos/' . $circuito->id) }}"
                              method="POST"
                              class="d-inline delete-form"
                              data-name="circuito">

                            @csrf
                            {{ method_field('DELETE') }}

                            <button type="submit"
                                    class="btn btn-danger btn-sm">

                                <i class="bi bi-trash"></i>

                            </button>

                        </form>

                        @endif

                    </div>

                </div>

            </div>

        </div>

        @empty

        <div class="col-12">

            <div class="alert alert-info text-center">

                No se encontraron circuitos

            </div>

        </div>

        @endforelse

    </div>

    {{-- PAGINACIÓN --}}
    <div class="mt-3">

        {!! $circuitos->links() !!}

    </div>

</div>

@endsection