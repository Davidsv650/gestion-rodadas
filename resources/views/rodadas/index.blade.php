@extends('layouts.app')

@section('content')

<style>

/* 🔥 HOVER SUAVE CARDS */
.card-hover {

    transition: all 0.3s ease;

    position: relative;

    overflow: hidden;

}

.card-hover:hover {

    transform: translateY(-5px);

    box-shadow: 0 10px 25px rgba(0,0,0,0.15);

}

/* 🔥 BOTONES MÁS ELEGANTES */
.btn {

    transition: all 0.25s ease;

}

.btn:hover {

    transform: translateY(-2px);

}

/* 🔥 BANDA RODADA REALIZADA */
.ribbon-realizada {

    position: absolute;

    top: 28px;

    right: -52px;

    width: 220px;

    background: #f0041b;

    color: white;

    text-align: center;

    transform: rotate(35deg);

    font-size: 12px;

    font-weight: bold;

    letter-spacing: 1px;

    padding: 10px 0;

    z-index: 10;

    box-shadow: 0 4px 12px rgba(0,0,0,0.25);

}

</style>

@php
    $esAdmin = auth()->user()->rol === 'admin';
@endphp

@if(Session::has('mensaje'))

<div class="alert alert-success alert-dismissible fade show" role="alert">

    {{ Session::get('mensaje') }}

    <button type="button"
            class="btn-close"
            data-bs-dismiss="alert">
    </button>

</div>

@endif

<div class="container mt-4">

    {{-- CABECERA --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1>

            @if(auth()->user()->rol === 'organizador')
                Mis Rodadas
            @else
                Rodadas
            @endif

        </h1>

        @if($esAdmin || auth()->user()->rol === 'organizador')

        <a href="{{ url('rodadas/create') }}"
           class="btn btn-primary">

            <i class="bi bi-plus-circle"></i>
            Crear Nueva Rodada

        </a>

        @endif

    </div>

    {{-- BUSCADOR --}}
    <div class="row mb-4">

        <form action="{{ route('rodadas.index') }}"
              method="GET"
              class="col-12">

            <div class="input-group">

                <input type="text"
                       class="form-control"
                       name="buscar"
                       placeholder="Buscar por circuito"
                       value="{{ $buscar ?? '' }}">

                <button class="btn btn-primary"
                        type="submit">

                    <i class="bi bi-search"></i>
                    Buscar

                </button>

            </div>

        </form>

    </div>

    {{-- GRID --}}
    <div class="row">

        @forelse($rodadas as $rodada)

        @php

            $usuarioSeleccionado = auth()->user()->id;

            $ocupadas = $rodada->inscritos->count();

            $inscripcion = $rodada->inscritos
                ->where('usuario_id', $usuarioSeleccionado)
                ->first();

            $realizada = $rodada->fecha < now();

            $esOrganizadorDeLaRodada =
                auth()->user()->rol === 'organizador' &&
                $rodada->organizador->email === auth()->user()->email;

        @endphp

        <div class="col-md-4 mb-4">

            <div class="card h-100 shadow-sm card-hover
                {{ $realizada ? 'opacity-75 border-dark' : '' }}
                {{ $inscripcion ? 'border-success-subtle bg-light' : '' }}">

                {{-- 🔥 BANDA --}}
                @if($realizada)

                <div class="ribbon-realizada">

                    RODADA REALIZADA

                </div>

                @endif

                <div class="card-body d-flex flex-column">

                    {{-- CABECERA CARD --}}
                    <div class="d-flex justify-content-between align-items-start">

                        <div>

                            <h5 class="card-title">

                                {{ $rodada->titulo }}

                            </h5>

                            @if($inscripcion)

                            <span class="badge rounded-pill text-bg-success">

                                Inscrito

                            </span>

                            @endif

                        </div>

                        {{-- ADMIN Y ORGANIZADOR --}}
                        @if($esAdmin || $esOrganizadorDeLaRodada)

                        <div>

                            <a href="{{ url('/rodadas/' . $rodada->id . '/edit') }}"
                               class="btn btn-success btn-sm me-1">

                                <i class="bi bi-pencil"></i>

                            </a>

                            <form action="{{ url('/rodadas/' . $rodada->id) }}"
                                  method="POST"
                                  class="d-inline delete-form"
                                  data-name="rodada">

                                @csrf
                                {{ method_field('DELETE') }}

                                <button type="submit"
                                        class="btn btn-danger btn-sm">

                                    <i class="bi bi-trash"></i>

                                </button>

                            </form>

                        </div>

                        @endif

                    </div>

                    {{-- INFO --}}
                    <p class="mt-3">

                        <strong>📅 Fecha:</strong>
                        {{ $rodada->fecha->format('d-m-Y') }}<br>

                        <strong>🏁 Circuito:</strong>
                        {{ $rodada->circuito->nombre }}<br>

                        <strong>👤 Organizador:</strong>
                        {{ $rodada->organizador->nombre }}<br>

                        <strong>💰 Precio:</strong>
                        {{ $rodada->precio }} €<br>

                        <strong>🎟️ Plazas:</strong>
                        {{ $rodada->plazas }}

                        @if($realizada)

                        <span class="badge rounded-pill bg-dark ms-2">

                            Finalizada

                        </span>

                        @elseif($ocupadas >= $rodada->plazas)

                        <span class="badge rounded-pill bg-danger-subtle text-danger ms-2">

                            Completo

                        </span>

                        @elseif($ocupadas >= ($rodada->plazas - 5))

                        <span class="badge rounded-pill bg-warning-subtle text-dark ms-2">

                            Últimas plazas

                        </span>

                        @else

                        <span class="badge rounded-pill bg-success-subtle text-success ms-2">

                            Disponible

                        </span>

                        @endif

                    </p>

                    {{-- BOTONES --}}
                    <div class="mt-auto">

                        <a href="{{ url('/calendario') }}?fecha={{ $rodada->fecha }}"
                           class="btn btn-primary btn-sm me-1 mb-1">

                            Ver calendario

                        </a>

                        <a href="{{ url('/rodadas/'.$rodada->id) }}"
                           class="btn btn-dark btn-sm me-1 mb-1">

                            Ver detalles

                        </a>

                        {{-- ADMIN --}}
                        @if($esAdmin)

                        <a href="{{ url('/inscripciones?rodada_id=' . $rodada->id) }}"
                           class="btn btn-outline-primary btn-sm me-1 mb-1">

                            Ver inscritos

                        </a>

                        @endif

                        {{-- INSCRIPCIÓN --}}
                        @if($realizada)

                        <button class="btn btn-outline-dark btn-sm me-1 mb-1" disabled>

                            Rodada finalizada

                        </button>

                        @elseif($inscripcion)

                        <form action="{{ url('/inscripciones/'.$inscripcion->id) }}"
                              method="POST"
                              class="d-inline delete-form"
                              data-name="inscripción">

                            @csrf
                            {{ method_field('DELETE') }}

                            <button type="submit"
                                    class="btn btn-outline-danger btn-sm me-1 mb-1">

                                Cancelar inscripción

                            </button>

                        </form>

                        @elseif($ocupadas >= $rodada->plazas)

                        <button class="btn btn-secondary btn-sm me-1 mb-1" disabled>

                            Completo

                        </button>

                        @elseif(auth()->user()->rol === 'usuario')

                        <form action="{{ url('/inscripciones') }}"
                              method="POST"
                              class="d-inline">

                            @csrf

                            <input type="hidden"
                                   name="rodada_id"
                                   value="{{ $rodada->id }}">

                            <input type="hidden"
                                   name="usuario_id"
                                   value="{{ auth()->user()->id }}">

                            <input type="hidden"
                                   name="fecha"
                                   value="{{ date('Y-m-d') }}">

                            <input type="hidden"
                                   name="estado"
                                   value="inscrito">

                            <button type="submit"
                                    class="btn btn-success btn-sm me-1 mb-1">

                                Inscribirse

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

                No se encontraron rodadas para ese circuito

            </div>

        </div>

        @endforelse

    </div>

    {{-- PAGINACIÓN --}}
    <div class="mt-3">

        {!! $rodadas->links() !!}

    </div>

</div>

@endsection