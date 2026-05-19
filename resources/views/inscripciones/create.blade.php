@extends('layouts.app')
@section('content')

<div class="container">

<h1>Inscribirse</h1>

<br><br>
<form action="{{url('/inscripciones')}}" method="post" enctype="multipart/form-data">
    @csrf
    @include('inscripciones.form',['submit'=>'Anadir inscripción' ,'cancel'=> 'Cancelar la inserción'])

</form>
</div>
@endsection