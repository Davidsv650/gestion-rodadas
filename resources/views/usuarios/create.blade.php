@extends('layouts.app')
@section('content')

<div class="container">

<h1>Inserta un Usuario</h1>

<br><br>
<form action="{{url('/usuarios')}}" method="post" enctype="multipart/form-data">
    @csrf
    @include('usuarios.form',['submit'=>'Anadir usuario' ,'cancel'=> 'Cancelar la inserción'])

</form>
</div>
@endsection