@extends('layouts.app')
@section('content')

<div class="container">


<h1>Modificar una inscripción</h1>



<br><br>
<form action="{{ url('/inscripciones/' . $inscripcion->id)}}" method="POST" enctype="multipart/form-data">
    @csrf{{ method_field('PATCH')}}
    @include('inscripciones.form',['submit' => 'Modificar una inscripcion','cancel' => 'Cancelar la modificación'])
</form>

</div>

@endsection