<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
 public function index(Request $request)
{
    $buscar = $request->buscar;

    $usuarios = Usuario::where('nombre', 'like', "%$buscar%")
        ->orWhere('email', 'like', "%$buscar%")
        ->paginate(10);

    $usuarios->appends([
        'buscar' => $buscar
    ]);

    return view('usuarios.index', compact('usuarios', 'buscar'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        return view('usuarios.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $campos =[
           'nombre'=> 'required|string|max:255',
            'email'=> 'required|email|max:255',
             'password' => 'required|string|min:6',
            'rol'=> 'required|string|max:255'
           
            
            
          
        ];

        $mensajes =[
            'required' => 'El :attribute es requerido.',
            'direccion.required' => 'La :attribute es requerida.'
        ];
         $this->validate($request,$campos,$mensajes);

        $datos = $request->except('_token');
    $datos['password'] = Hash::make($request->password);

    // 🔥 usar create en vez de insert
    Usuario::create($datos);

    return redirect('usuarios')->with('mensaje', 'Usuario creado');

    }

    /**
     * Display the specified resource.
     */
    public function show(Usuario $usuario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $usuario = Usuario::findOrFail($id);

        return view('usuarios.edit', compact('usuario'));
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, $id)
{
    $campos = [
        'nombre' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'rol' => 'required|string|max:255'
    ];

    $mensajes = [
        'required' => 'El :attribute es requerido.',
        'direccion.required' => 'La :attribute es requerida.'
    ];

    $this->validate($request, $campos, $mensajes);

    $datos = $request->except(['_token', '_method']);

    // Si se escribe nueva contraseña → encriptarla
    if ($request->filled('password')) {
        $datos['password'] = Hash::make($request->password);
    } else {
        // Si no se escribe contraseña → no tocarla
        unset($datos['password']);
    }

    Usuario::where('id', '=', $id)->update($datos);

    return redirect('usuarios')->with('mensaje', 'Usuario actualizado');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        //
          Usuario::destroy($id);

        return redirect('usuarios')->with('mensaje','Usuario borrado.');
    }
}
