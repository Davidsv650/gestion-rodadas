@if (count($errors) > 0)

<div class="alert alert-danger" role="alert">

<ul>

    @foreach($errors->all() as $error)

    <li>{{ $error}}</li>

    @endforeach

</ul>

</div>

@endif

<label for="titulo">Título</label>

<input type="text"
       name="titulo"
       id="titulo"
       maxlength="255"
       class="form-control"
       value="{{ isset($rodada->titulo) ? $rodada->titulo : old('titulo') }}">

<br>

<label for="descripcion">Descripción</label>

<input type="text"
       name="descripcion"
       id="descripcion"
       maxlength="1000"
       class="form-control"
       value="{{ isset($rodada->descripcion) ? $rodada->descripcion : old('descripcion') }}">

<br>

<label for="fecha">Fecha</label>

<input type="date"
       name="fecha"
       id="fecha"
       class="form-control"
       value="{{ isset($rodada->fecha) ? $rodada->fecha->format('Y-m-d') : old('fecha') }}">

<br>

<label for="precio">Precio</label>

<input type="number"
       step="0.01"
       name="precio"
       id="precio"
       class="form-control"
       value="{{ isset($rodada->precio) ? $rodada->precio : old('precio') }}">

<br>

<label for="plazas">Plazas disponibles</label>

<input type="number"
       name="plazas"
       id="plazas"
       class="form-control"
       value="{{ isset($rodada->plazas) ? $rodada->plazas : old('plazas') }}">

<br>

<label for="circuito_id">Circuito</label>

<select name="circuito_id"
        id="circuito_id"
        class="form-control">

<option value="">

    Selecciona un circuito

</option>

@foreach($circuitos as $circuito)

<option value="{{ $circuito->id }}"

@if(isset($rodada->circuito_id) && $rodada->circuito_id == $circuito->id)

selected

@endif
>

{{ $circuito->nombre }}

</option>

@endforeach

</select>

<br>


@if (isset($submit))

<input type="submit"
       class="btn btn-primary"
       value="{{ $submit}}">

@endif

<a href="{{ url('/rodadas')}}">

<input type="button"
       class="btn btn-danger"
       value="{{ $cancel}}">

</a>