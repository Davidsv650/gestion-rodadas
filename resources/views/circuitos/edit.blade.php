@extends('layouts.app')
@section('content')

<div class="container">


<h1>Modificar un circuito</h1>



<br><br>
<form action="{{ url('/circuitos/' . $circuito->id)}}" method="POST" enctype="multipart/form-data">
    @csrf{{ method_field('PATCH')}}
    @include('circuitos.form',['submit' => 'Modificar un circuito','cancel' => 'Cancelar la modificación'])
</form>

</div>

@endsection