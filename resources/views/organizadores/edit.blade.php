@extends('layouts.app')
@section('content')

<div class="container">


<h1>Modificar un organizador</h1>



<br><br>
<form action="{{ url('/organizadores/' . $organizador->id)}}" method="POST" enctype="multipart/form-data">
    @csrf{{ method_field('PATCH')}}
    @include('organizadores.form',['submit' => 'Modificar un organizador','cancel' => 'Cancelar la modificación'])
</form>

</div>

@endsection