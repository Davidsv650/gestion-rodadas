@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}

                        <br><br>
                     <a href="{{ url('circuitos/')}}">Circuitos</a>
                    <a href="{{ url('usuarios/')}}">Usuarios</a>
                     <a href="{{ url('organizadores/')}}">Organizadores</a>
                      <a href="{{ url('rodadas/')}}">Rodadas</a>
                       <a href="{{ url('inscripciones/')}}">Ins</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
