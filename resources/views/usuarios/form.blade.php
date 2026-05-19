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
value="{{ isset($usuario->nombre) ? $usuario->nombre : old('nombre')}}" @if (isset($readonly)) {{$readonly}} @endif>
<br>
<label for="email">Email</label>
<input type="email" name="email" id="email" maxlength="255" class="form-control"
value="{{ isset($usuario->email) ? $usuario->email : old('email')}}" @if (isset($readonly)) {{$readonly}} @endif>
<br>
<label for="password">Contraseña</label>
<input type="password" name="password" id="password" maxlength="255" class="form-control">

<br>
<label for="rol">Rol de usuario</label>
<select name="rol" id="rol" class="form-control">

<option value="usuario"
{{ isset($usuario) && $usuario->rol == 'usuario' ? 'selected' : '' }}>
Usuario
</option>

<option value="organizador"
{{ isset($usuario) && $usuario->rol == 'organizador' ? 'selected' : '' }}>
Organizador
</option>

<option value="admin"
{{ isset($usuario) && $usuario->rol == 'admin' ? 'selected' : '' }}>
Administrador
</option>

</select>
<br>



@if (isset($submit))
<input type="submit" class="btn btn-primary" value="{{ $submit}}">
@else
<br>
@endif
<a href="{{ url('/usuarios')}}">
<input type="button" class="btn btn-danger" value="{{ $cancel}}">
</a>