@if (count($errors) > 0)

<div class="alert alert-danger" role="alert">

<ul>

    @foreach($errors->all() as $error)

    <li>{{ $error}}</li>

    @endforeach

</ul>

</div>

@endif

{{-- NOMBRE --}}
<label for="nombre">

    Nombre

</label>

<input type="text"
       name="nombre"
       id="nombre"
       maxlength="255"
       class="form-control"
       value="{{ isset($circuito->nombre) ? $circuito->nombre : old('nombre')}}"
       @if (isset($readonly)) {{$readonly}} @endif>

<br>

{{-- UBICACIÓN --}}
<label for="ubicacion">

    Ubicación

</label>

<input type="text"
       name="ubicacion"
       id="ubicacion"
       maxlength="255"
       class="form-control"
       value="{{ isset($circuito->ubicacion) ? $circuito->ubicacion : old('ubicacion')}}"
       @if (isset($readonly)) {{$readonly}} @endif>

<br>

{{-- LONGITUD --}}
<label for="longitud">

    Longitud (km)

</label>

<input type="number"
       step="0.1"
       name="longitud"
       id="longitud"
       class="form-control"
       value="{{ isset($circuito->longitud) ? $circuito->longitud : old('longitud')}}"
       @if (isset($readonly)) {{$readonly}} @endif>

<br>

{{-- CURVAS --}}
<label for="numero_de_curvas">

    Número de Curvas

</label>

<input type="number"
       name="numero_de_curvas"
       id="numero_de_curvas"
       maxlength="11"
       class="form-control"
       value="{{ isset($circuito->numero_de_curvas) ? $circuito->numero_de_curvas : old('numero_de_curvas')}}"
       @if (isset($readonly)) {{$readonly}} @endif>

<br>

{{-- FRASE --}}
<label for="frase">

    Frase promocional

</label>

<input type="text"
       name="frase"
       id="frase"
       maxlength="255"
       class="form-control"
       placeholder="Ej: Velocidad y adrenalina en cada curva"
       value="{{ isset($circuito->frase) ? $circuito->frase : old('frase')}}"
       @if (isset($readonly)) {{$readonly}} @endif>

<small class="text-muted">

    Esta frase aparecerá en la cabecera de las rodadas.

</small>

<br><br>

{{-- DESCRIPCIÓN --}}
<label for="descripcion">

    Descripción

</label>

<input type="text"
       name="descripcion"
       id="descripcion"
       maxlength="1000"
       class="form-control"
       value="{{ isset($circuito->descripcion) ? $circuito->descripcion : old('descripcion')}}"
       @if (isset($readonly)) {{$readonly}} @endif>

<br>

{{-- IMAGEN PRINCIPAL --}}
<div class="form-group">

@if (isset($circuito->imagen))

<img src="{{ asset('storage') . '/' . $circuito->imagen}}"
     style="height: 150px!important"
     class="img-thumbnail img-fluid">

@else

<label for="imagen">

    Imagen principal

</label>

@endif

<input type="file"
       name="imagen"
       id="imagen"
       accept="image/*"
       class="form-control">

</div>

<br>

{{-- GALERÍA --}}
<label for="imagenes">

    Galería del circuito

</label>

<input type="file"
       name="imagenes[]"
       id="imagenes"
       multiple
       accept="image/*"
       class="form-control">

<small class="text-muted">

    Puedes seleccionar varias imágenes para el carrusel.

</small>

<br><br>

{{-- BOTONES --}}
@if (isset($submit))

<input type="submit"
       class="btn btn-primary"
       value="{{ $submit}}">

@else

<br>

@endif

<a href="{{ url('/circuitos')}}">

<input type="button"
       class="btn btn-danger"
       value="{{ $cancel}}">

</a>