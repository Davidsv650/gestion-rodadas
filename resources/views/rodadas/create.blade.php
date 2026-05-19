@extends('layouts.app')
@section('content')

<div class="container">

<h1>Inserta una rodada</h1>

<br><br>
<form action="{{url('/rodadas')}}" method="post" enctype="multipart/form-data">
    @csrf
    @include('rodadas.form',['submit'=>'Anadir rodada' ,'cancel'=> 'Cancelar la inserción'])

</form>
</div>
@endsection