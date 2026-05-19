@if (count($errors) > 0)
<div class="alert alert-danger" role="alert">
<ul>
    @foreach($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
</ul>
</div>
@endif

{{-- RODADA --}}
<label for="rodada_id">Rodada</label>
<select name="rodada_id" id="rodada_id" class="form-control">
<option value="">Selecciona una rodada</option>

@foreach($rodadas as $rodada)
<option value="{{ $rodada->id }}"
@if(isset($inscripcion->rodada_id) && $inscripcion->rodada_id == $rodada->id)
selected
@endif
>
{{ $rodada->titulo }} - {{ $rodada->circuito->nombre }}
</option>
@endforeach

</select>
<br>

{{-- FECHA --}}
<label for="fecha">Fecha de inscripción</label>
<input type="date" name="fecha" id="fecha" class="form-control"
value="{{ isset($inscripcion->fecha) ? $inscripcion->fecha->format('Y-m-d') : old('fecha') }}">
<br>

{{-- ESTADO --}}
<label for="estado">Estado</label>
<select name="estado" id="estado" class="form-control">
<option value="inscrito" {{ (isset($inscripcion) && $inscripcion->estado=='inscrito') ? 'selected' : '' }}>
    Inscrito
</option>
<option value="no_inscrito" {{ (isset($inscripcion) && $inscripcion->estado=='no_inscrito') ? 'selected' : '' }}>
    No inscrito
</option>
</select>
<br>

{{-- BOTÓN --}}
@if (isset($submit))
<input type="submit" class="btn btn-primary" value="{{ $submit }}">
@else
<br>
@endif

<a href="{{ url('/inscripciones') }}">
<input type="button" class="btn btn-danger" value="{{ $cancel }}">
</a>