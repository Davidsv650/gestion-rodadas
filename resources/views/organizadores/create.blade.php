@extends('layouts.app')
@section('content')

<div class="container">

<h1>Inserta un organizador</h1>

<br><br>
<form action="{{url('/organizadores')}}" method="post" enctype="multipart/form-data">
    @csrf
    @include('organizadores.form',['submit'=>'Anadir organizador' ,'cancel'=> 'Cancelar la inserción'])

</form>
</div>

@endsection



