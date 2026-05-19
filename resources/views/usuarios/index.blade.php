@extends('layouts.app')

@section('content')

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

        <h1>Usuarios</h1>

        <a href="{{ url('usuarios/create') }}"
           class="btn btn-primary">

            <i class="bi bi-plus-circle"></i>
            Crear Nuevo Usuario

        </a>

    </div>

    {{-- BUSCADOR --}}
    <div class="row mb-4">

        <form action="{{ route('usuarios.index') }}"
              method="GET"
              class="col-12">

            <div class="input-group">

                <input type="text"
                       class="form-control"
                       name="buscar"
                       placeholder="Buscar por nombre o email"
                       value="{{ $buscar ?? '' }}">

                <button class="btn btn-primary"
                        type="submit">

                    <i class="bi bi-search"></i>
                    Buscar

                </button>

            </div>

        </form>

    </div>

    {{-- TABLA --}}
    <div class="table-responsive">

        <table class="table table-hover align-middle">

            <thead class="table-dark">

                <tr>

                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol de Usuario</th>
                    <th class="text-end">Acciones</th>

                </tr>

            </thead>

            <tbody>

                @forelse ($usuarios as $usuario)

                <tr>

                    <td>{{ $usuario->nombre }}</td>

                    <td>{{ $usuario->email }}</td>

                    <td>

                        <span class="badge bg-primary">
                            {{ $usuario->rol }}
                        </span>

                    </td>

                    <td class="text-end">

                        <a href="{{ url('/usuarios/' . $usuario->id . '/edit')}}"
                           class="btn btn-success btn-sm">

                            <i class="bi bi-pencil"></i>

                        </a>

                        <form action="{{ url('/usuarios/' . $usuario->id)}}"
                              method="POST"
                              class="d-inline delete-form"
                              data-name="usuario">

                            @csrf
                            {{ method_field('DELETE')}}

                            <button type="submit"
                                    class="btn btn-danger btn-sm">

                                <i class="bi bi-trash"></i>

                            </button>

                        </form>

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="4" class="text-center">

                        No se encontraron usuarios

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    {{-- PAGINACIÓN --}}
    <div class="mt-3">

        {!! $usuarios->links() !!}

    </div>

</div>

@endsection