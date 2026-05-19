@extends('layouts.app')
@section('content')

<div class="container">


<h1>Modificar una rodada</h1>



<br><br>
<form action="{{ url('/rodadas/' . $rodada->id)}}" method="POST" enctype="multipart/form-data">
    @csrf{{ method_field('PATCH')}}
    @include('rodadas.form',['submit' => 'Modificar una rodada','cancel' => 'Cancelar la modificación'])
</form>

</div>

@endsection