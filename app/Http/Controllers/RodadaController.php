<?php

namespace App\Http\Controllers;

use App\Models\Rodada;
use App\Models\Circuito;
use App\Models\Organizador;
use App\Models\Usuario;
use Illuminate\Http\Request;

class RodadaController extends Controller
{
    public function index(Request $request)
{
    $buscar = $request->buscar;

    // organizador
    if (auth()->user()->rol === 'organizador') {

        $organizador = Organizador::where(
            'email',
            auth()->user()->email
        )->first();

        if ($organizador) {

            $rodadas = Rodada::with([
                    'circuito',
                    'organizador',
                    'inscritos'
                ])

                ->where('organizador_id', $organizador->id)

                // buscador
                ->when($buscar, function ($query) use ($buscar) {

                    $query->whereHas('circuito', function ($q) use ($buscar) {

                        $q->whereRaw(
                            'LOWER(nombre) LIKE ?',
                            ['%' . strtolower($buscar) . '%']
                        );

                    });

                })

                // ordenar por fecha
                ->orderBy('fecha', 'asc')

                ->paginate(10);

        } else {

            $rodadas = collect();

        }

    } else {

        // adminstrador y usuario normal
        $rodadas = Rodada::with([
                'circuito',
                'organizador',
                'inscritos'
            ])

            // buscador de rodadas
            ->when($buscar, function ($query) use ($buscar) {

                $query->whereHas('circuito', function ($q) use ($buscar) {

                    $q->whereRaw(
                        'LOWER(nombre) LIKE ?',
                        ['%' . strtolower($buscar) . '%']
                    );

                });

            })

            // ordenaro por fecha
            ->orderBy('fecha', 'asc')

            ->paginate(10);

    }

    $rodadas->appends([
        'buscar' => $buscar
    ]);

    return view('rodadas.index', compact('rodadas', 'buscar'));
}

    public function create()
    {
        $circuitos = Circuito::all();

        $organizadores = Organizador::all();

        return view('rodadas.create', compact(
            'circuitos',
            'organizadores'
        ));
    }

    public function store(Request $request)
    {
        $campos = [

            'titulo'=> 'required|string|max:255',
            'descripcion'=> 'required|string|max:1000',
            'fecha'=> 'required|date',
            'plazas'=> 'required|numeric',
            'precio'=> 'required|numeric',
            'circuito_id'=> 'required'

        ];

        $this->validate($request, $campos);

        $datos = $request->except('_token');

        // buscar organizador por email
        $organizador = Organizador::where(
            'email',
            auth()->user()->email
        )->first();

        // aginacion de organizador
        $datos['organizador_id'] = $organizador->id;

        //crear rodada
        Rodada::create($datos);

        return redirect('rodadas')
            ->with('mensaje', 'Rodada creada correctamente');
    }

public function show(Rodada $rodada)
{
    // finalización automatica por fecha
    $rodada->finalizada = $rodada->fecha < now();

    // cargar relaciones
    $rodada->load([

        'circuito.imagenes',

        'organizador'

    ]);

    return view(
        'rodadas.show',
        compact('rodada')
    );
}

    public function edit($id)
    {
        $rodada = Rodada::findOrFail($id);

        $circuitos = Circuito::all();

        $organizadores = Organizador::all();

        return view('rodadas.edit', compact(
            'rodada',
            'circuitos',
            'organizadores'
        ));
    }

    public function update(Request $request ,$id)
    {
        $campos = [

            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string|max:1000',
            'fecha' => 'required|date',
            'plazas' => 'required|numeric',
            'precio' => 'required|numeric',
            'circuito_id' => 'required'

        ];

        $mensajes = [

            'required' => 'El :attribute es requerido.'

        ];

        $this->validate($request, $campos, $mensajes);

        $datos = $request->except([
            '_token',
            '_method'
        ]);

        Rodada::where('id','=',$id)->update($datos);

        return redirect('rodadas')
            ->with('mensaje','Rodada modificada');
    }

    public function destroy($id)
    {
        Rodada::destroy($id);

        return redirect('rodadas')
            ->with('mensaje','Rodada borrada.');
    }

    public function rodadasJson(Request $request)
    {
        $query = Rodada::with([
            'circuito',
            'organizador'
        ]);

        // filtro de circuitos
        if ($request->filled('circuito_id')) {

            $query->where(
                'circuito_id',
                $request->circuito_id
            );

        }

        // filtro de organizador
        if ($request->filled('organizador_id')) {

            $query->where(
                'organizador_id',
                $request->organizador_id
            );

        }

        // ordenar por fecha
        $rodadas = $query
            ->orderBy('fecha', 'asc')
            ->get();

        return response()->json(

            $rodadas->map(function($rodada) {

                return [

                    'id' => $rodada->id,

                    'title' => $rodada->titulo,

                    'start' => $rodada->fecha->format('Y-m-d'),

                    // fullcalendar 
                    'extendedProps' => [

                        'circuito' =>
                            $rodada->circuito->nombre,

                        'organizador' =>
                            $rodada->organizador->nombre,

                        'precio' =>
                            $rodada->precio,

                        'plazas' =>
                            $rodada->plazas,

                        'imagen' =>
                            $rodada->circuito->imagen,

                    ],

                ];

            })

        );
    }
}