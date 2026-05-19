@extends('layouts.app')
@section('content')

<div class="container">

<h1>Insertar Circuito</h1>

<br><br>
<form action="{{url('/circuitos')}}" method="post" enctype="multipart/form-data">
    @csrf
    @include('circuitos.form',['submit'=>'Anadir circuito' ,'cancel'=> 'Cancelar la inserción'])

</form>
</div>
@endsection