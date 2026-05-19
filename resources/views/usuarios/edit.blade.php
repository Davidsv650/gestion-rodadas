@extends('layouts.app')
@section('content')

<div class="container">


<h1>Modificar un usuario</h1>



<br><br>
<form action="{{ url('/usuarios/' . $usuario->id)}}" method="POST" enctype="multipart/form-data">
    @csrf{{ method_field('PATCH')}}
    @include('usuarios.form',['submit' => 'Modificar un usuario','cancel' => 'Cancelar la modificación'])
</form>

</div>

@endsection