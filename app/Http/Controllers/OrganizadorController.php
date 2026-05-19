<?php

namespace App\Http\Controllers;

use App\Models\Organizador;
use Illuminate\Http\Request;

class OrganizadorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index(Request $request)
{
    $buscar = $request->buscar;

    $organizadores = Organizador::where('nombre', 'like', "%$buscar%")
        ->paginate(10);

    $organizadores->appends([
        'buscar' => $buscar
    ]);

    return view('organizadores.index', compact('organizadores', 'buscar'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
         return view('organizadores.create');
        

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
         $campos =[
           'nombre'=> 'required|string|max:255',
            'descripcion'=> 'required|string|max:1000',
            'web'=> 'required|string|max:255',
            'telefono'=> 'required|string|max:255',
            'email'=> 'required|string|max:255',
            
            
          
        ];

        $mensajes =[
            'required' => 'El :attribute es requerido.',
            'direccion.required' => 'La :attribute es requerida.'
        ];
         $this->validate($request,$campos,$mensajes);

       // $datos=$request->all();
       $datos=$request->except('_token');
        Organizador::insert($datos);
        return redirect('organizadores')->with('mensaje', 'Organizador creado');
    }

    /**
     * Display the specified resource.
     */
    public function show(Organizador $organizador)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id)
    {
        //
        $organizador = Organizador::findOrFail($id);

        return view('organizadores.edit', compact('organizador'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        //

          $campos =[
           'nombre'=> 'required|string|max:255',
            'descripcion'=> 'required|string|max:1000',
            'web'=> 'required|string|max:255',
            'telefono'=> 'required|string|max:255',
            'email'=> 'required|string|max:255',
            
            
          
        ];

        $mensajes =[
            'required' => 'El :attribute es requerido.',
            'direccion.required' => 'La :attribute es requerida.'
        ];

         $this->validate($request,$campos,$mensajes);


        $datos = $request->except(['_token', '_method']);

       
        Organizador::where('id', '=', $id)->update($datos);

        return redirect('organizadores')->with('mensaje' ,'Organizador modificado.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        //
          Organizador::destroy($id);

        return redirect('organizadores')->with('mensaje','Organizador borrado.');
    }
}
