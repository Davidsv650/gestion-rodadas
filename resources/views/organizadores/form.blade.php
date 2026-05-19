@if (count($errors) > 0)
<div class="alert alert-danger" role="alert">
<ul>
    @foreach($errors->all() as $error)
    <li>{{ $error}}</li>
    @endforeach
</ul>
</div>
@endif
<label for="nombre">Nombre</label>
<input type="text" name="nombre" id="nombre" maxlength="255" class="form-control"
value="{{ isset($organizador->nombre) ? $organizador->nombre : old('nombre')}}" @if (isset($readonly)) {{$readonly}} @endif>
<br>
<label for="descripcion">Descripción</label>
<input type="text" name="descripcion" id="descripcion" maxlength="1000" class="form-control"
value="{{ isset($organizador->descripcion) ? $organizador->descripcion : old('descripcion')}}" @if (isset($readonly)) {{$readonly}} @endif>
<br>

<label for="telefono">Teléfono</label>
<input type="text" name="telefono" id="telefono" maxlength="255" class="form-control"
value="{{ isset($organizador->telefono) ? $organizador->telefono : old('telefono')}}" @if (isset($readonly)) {{$readonly}} @endif>
<br>
<label for="email">Email</label>
<input type="email" name="email" id="email" maxlength="255" class="form-control"
value="{{ isset($organizador->email) ? $organizador->email : old('email')}}" @if (isset($readonly)) {{$readonly}} @endif>
<br>
<label for="web">Página web</label>
<input type="text" name="web" id="web" maxlength="255" class="form-control"
value="{{ isset($organizador->web) ? $organizador->web : old('web')}}" @if (isset($readonly)) {{$readonly}} @endif>
<br>



@if (isset($submit))
<input type="submit" class="btn btn-primary" value="{{ $submit}}">
@else
<br>
@endif
<a href="{{ url('/organizadores')}}">
<input type="button" class="btn btn-danger" value="{{ $cancel}}">
</a>