<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'TodoRodadas') }}</title>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    {{-- ICONOS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    {{-- VITE --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<!-- Modal Confirmar Eliminación -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header bg-danger text-white">

                <h5 class="modal-title">
                    Confirmar eliminación
                </h5>

                <button type="button"
                        class="btn-close btn-close-white"
                        data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body" id="deleteModalText" >

                ¿Seguro que quieres eliminar este elemento?

            </div>

            <div class="modal-footer">

                <button type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">

                    Cancelar

                </button>

                <button type="button"
                        class="btn btn-danger"
                        id="confirmDeleteButton">

                    Eliminar

                </button>

            </div>

        </div>

    </div>

</div>
<script>

    let formToSubmit;

    document.addEventListener('DOMContentLoaded', function () {

        const deleteForms = document.querySelectorAll('.delete-form');

        deleteForms.forEach(form => {

            form.addEventListener('submit', function (e) {

                e.preventDefault();

                formToSubmit = this;

                const itemName = this.dataset.name || 'elemento';

                document.getElementById('deleteModalText')
                    .innerText =
                    `¿Seguro que quieres eliminar este ${itemName}?`;

                const modal = new bootstrap.Modal(
                    document.getElementById('confirmDeleteModal')
                );

                modal.show();

            });

        });

        document.getElementById('confirmDeleteButton')
            .addEventListener('click', function () {

                formToSubmit.submit();

            });

    });

</script>
<body>
<div id="app">

@php
    $esAdmin = auth()->check() && auth()->user()->rol === 'admin';
    $esOrganizador = auth()->check() && auth()->user()->rol === 'organizador';
@endphp

{{-- LOGO ARRIBA --}}
<div class="bg-white text-center py-3">
    <a href="{{ url('/') }}">
        <img src="{{ asset('img/logo-todorodadas.png') }}"
             alt="TodoRodadas"
             style="height: 140px;">
    </a>
</div>

{{-- NAVBAR --}}
<nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm border-top border-secondary">
    <div class="container">

        {{-- BOTÓN RESPONSIVE --}}
        <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            {{-- IZQUIERDA --}}
            <ul class="navbar-nav me-auto">

                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ url('/calendario') }}">
                        Calendario
                    </a>
                </li>

                @if($esAdmin)
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('usuarios.index') }}">
                        Usuarios
                    </a>
                </li>
                @endif

                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('rodadas.index') }}">
                        Rodadas
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('circuitos.index') }}">
                        Circuitos
                    </a>
                </li>

                @if($esAdmin)
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('inscripciones.index') }}">
                            Inscripciones
                        </a>
                    </li>
                @elseif($esOrganizador)
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('inscripciones.index') }}">
                            Ver inscritos
                        </a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('inscripciones.index') }}">
                            Mis inscripciones
                        </a>
                    </li>
                @endif

                @if($esAdmin)
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('organizadores.index') }}">
                        Organizadores
                    </a>
                </li>
                @endif

            </ul>

            {{-- DERECHA --}}
            <ul class="navbar-nav ms-auto">

                @guest

                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('login') }}">
                            Iniciar sesión
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('register') }}">
                            Registro
                        </a>
                    </li>

                @else

                    <li class="nav-item dropdown">

                        <a class="nav-link dropdown-toggle text-white d-flex align-items-center"
                           href="#"
                           data-bs-toggle="dropdown">

                            <i class="bi bi-person-circle me-2"></i>

                            {{ auth()->user()->nombre ?? auth()->user()->name }}

                            <small class="ms-2 text-muted">
                                ({{ auth()->user()->rol }})
                            </small>

                        </a>

                        <ul class="dropdown-menu dropdown-menu-end">

                            <li>
                                <a class="dropdown-item"
                                   href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">

                                    <i class="bi bi-box-arrow-right me-2"></i>
                                    Cerrar sesión
                                </a>
                            </li>

                        </ul>

                        <form id="logout-form"
                              action="{{ route('logout') }}"
                              method="POST"
                              class="d-none">
                            @csrf
                        </form>

                    </li>

                @endguest

            </ul>

        </div>
    </div>
</nav>

{{-- CONTENIDO --}}
<main class="py-4">
    @yield('content')
</main>

</div>

{{-- 🔥 BOOTSTRAP JS SOLO AQUÍ --}}


</body>
</html>