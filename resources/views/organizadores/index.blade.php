@extends('layouts.app')

@section('content')

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

        <h1>Organizadores</h1>

        <a href="{{ url('organizadores/create') }}"
           class="btn btn-primary">

            <i class="bi bi-plus-circle"></i>
            Crear Nuevo Organizador

        </a>

    </div>

    {{-- BUSCADOR --}}
    <div class="row mb-4">

        <form action="{{ route('organizadores.index') }}"
              method="GET"
              class="col-12">

            <div class="input-group">

                <input type="text"
                       class="form-control"
                       name="buscar"
                       placeholder="Buscar organizador por nombre"
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

        @forelse($organizadores as $org)

        <div class="col-md-4 mb-4">

            <div class="card h-100 shadow-sm">

                <div class="card-body d-flex flex-column">

                    <h5 class="card-title">

                        {{ $org->nombre }}

                    </h5>

                    <p class="card-text">

                        {{ $org->descripcion }}

                    </p>

                    <p>

                        <strong>📞 Tel:</strong> {{ $org->telefono }}<br>

                        <strong>📧 Email:</strong> {{ $org->email }}<br>

                        @if($org->web)

                        <strong>🌐 Web:</strong>

                        <a href="{{ $org->web }}"
                           target="_blank">

                            {{ $org->web }}

                        </a>

                        @endif

                    </p>

                    @if($org->rodadas->count() > 0)

                    <p><strong>🏁 Rodadas:</strong></p>

                    <ul>

                        @foreach($org->rodadas as $rodada)

                        <li>

                            {{ $rodada->titulo }}

                            -

                            <a href="{{ url('/calendario') }}">
                                Ver calendario
                            </a>

                        </li>

                        @endforeach

                    </ul>

                    @else

                    <p class="text-muted">

                        No tiene rodadas asignadas

                    </p>

                    @endif

                    {{-- BOTONES --}}
                    <div class="mt-auto">

                        <a href="{{ url('/organizadores/' . $org->id . '/edit') }}"
                           class="btn btn-success btn-sm me-1">

                            <i class="bi bi-pencil"></i>

                        </a>

                        <form action="{{ url('/organizadores/' . $org->id) }}"
                              method="POST"
                              class="d-inline delete-form"
                              data-name="organizador">

                            @csrf
                            {{ method_field('DELETE') }}

                            <button type="submit"
                                    class="btn btn-danger btn-sm">

                                <i class="bi bi-trash"></i>

                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

        @empty

        <div class="col-12">

            <div class="alert alert-info text-center">

                No se encontraron organizadores

            </div>

        </div>

        @endforelse

    </div>

    {{-- PAGINACIÓN --}}
    <div class="mt-3">

        {!! $organizadores->links() !!}

    </div>

</div>

@endsection