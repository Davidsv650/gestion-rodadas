<?php

namespace App\Http\Controllers;

use App\Models\Circuito;
use App\Models\ImagenCircuito;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CircuitoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
  public function index(Request $request)
{
    $buscar = $request->buscar;
        $circuitos = Circuito::whereRaw(
        'LOWER(nombre) LIKE ?',
        ['%' . strtolower($buscar) . '%']
            )
    
        ->orderBy('id', 'asc')
        ->paginate(15);

    $circuitos->appends([
        'buscar' => $buscar
    ]);

    return view('circuitos.index', compact('circuitos', 'buscar'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('circuitos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $campos = [

        'nombre'=> 'required|string|max:255',
        'ubicacion'=> 'required|string|max:255',
        'descripcion'=> 'required|string|max:1000',
        'longitud'=> 'required|numeric|decimal:0,2|max:99999999999999999.99',

        'imagen'=> 'required|max:50000|mimes:jpg,jpeg,png',

        'imagenes.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096'

    ];

    $mensajes =[

        'required' => 'El :attribute es requerido.',
        'direccion.required' => 'La :attribute es requerida.'

    ];

    $this->validate($request,$campos,$mensajes);

    $datos = $request->except([
        '_token',
        'imagenes'
    ]);

    // imagen principal
    if ($request->hasFile('imagen')) {

        $datos['imagen'] = $request
            ->file('imagen')
            ->store('uploads','public');

    }

    // crear circuito
    $circuito = Circuito::create($datos);

    // galeria de circuitos
    if($request->hasFile('imagenes')) {

        foreach($request->file('imagenes') as $imagenGaleria) {

            $ruta = $imagenGaleria->store(
                'uploads/circuitos',
                'public'
            );

            ImagenCircuito::create([

                'circuito_id' => $circuito->id,

                'imagen' => $ruta

            ]);

        }

    }

    return redirect('circuitos')
        ->with('mensaje', 'Circuito creado');
}
    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id)
    {
        //
        $circuito = Circuito::findOrFail($id);

        return view('circuitos.edit', compact('circuito'));
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, $id)
{
    $campos =[

        'nombre'=> 'required|string|max:255',
        'ubicacion'=> 'required|string|max:255',
        'descripcion'=> 'required|string|max:1000',
        'longitud'=> 'required|numeric|decimal:0,2|max:99999999999999999.99',

        'imagen'=> 'nullable|max:50000|mimes:jpg,jpeg,png',

        'imagenes.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096'

    ];

    $mensajes =[

        'required' => 'El :attribute es requerido.',
        'direccion.required' => 'La :attribute es requerida.'

    ];

    $this->validate($request,$campos,$mensajes);

    $circuito = Circuito::findOrFail($id);

    $datos = $request->except([
        '_token',
        '_method',
        'imagenes'
    ]);

    // imagen principal del circuito
    if ($request->hasFile('imagen'))
    {
        Storage::delete('public/' . $circuito->imagen);

        $datos['imagen'] = $request
            ->file('imagen')
            ->store('uploads','public');
    }

    $circuito->update($datos);

    // imagenes del carrusel
    if($request->hasFile('imagenes')) {

        foreach($request->file('imagenes') as $imagenGaleria) {

            $ruta = $imagenGaleria->store(
                'uploads/circuitos',
                'public'
            );

            ImagenCircuito::create([

                'circuito_id' => $circuito->id,

                'imagen' => $ruta

            ]);

        }

    }

    return redirect('circuitos')
        ->with('mensaje','Circuito modificado');
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        //

          Circuito::destroy($id);

        return redirect('circuitos')->with('mensaje','Circuito Borrado.');
    }
}
