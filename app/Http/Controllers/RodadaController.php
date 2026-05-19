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

        // 🔥 ORGANIZADOR
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

                    // 🔥 BUSCADOR
                    ->when($buscar, function ($query) use ($buscar) {

                        $query->whereHas('circuito', function ($q) use ($buscar) {

                            $q->where('nombre', 'like', "%$buscar%");

                        });

                    })

                    // 🔥 ORDEN FECHA
                    ->orderBy('fecha', 'asc')

                    ->paginate(10);

            } else {

                $rodadas = collect();

            }

        } else {

            // 🔥 ADMIN Y USUARIO NORMAL
            $rodadas = Rodada::with([
                    'circuito',
                    'organizador',
                    'inscritos'
                ])

                // 🔥 BUSCADOR
                ->when($buscar, function ($query) use ($buscar) {

                    $query->whereHas('circuito', function ($q) use ($buscar) {

                        $q->where('nombre', 'like', "%$buscar%");

                    });

                })

                // 🔥 ORDEN FECHA
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

        // 🔥 BUSCAR ORGANIZADOR POR EMAIL
        $organizador = Organizador::where(
            'email',
            auth()->user()->email
        )->first();

        // 🔥 ASIGNAR ORGANIZADOR
        $datos['organizador_id'] = $organizador->id;

        // 🔥 CREAR
        Rodada::create($datos);

        return redirect('rodadas')
            ->with('mensaje', 'Rodada creada correctamente');
    }

public function show(Rodada $rodada)
{
    // 🔥 FINALIZADA AUTOMÁTICA
    $rodada->finalizada = $rodada->fecha < now();

    // 🔥 CARGAR RELACIONES
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

        // 🔥 FILTRO CIRCUITO
        if ($request->filled('circuito_id')) {

            $query->where(
                'circuito_id',
                $request->circuito_id
            );

        }

        // 🔥 FILTRO ORGANIZADOR
        if ($request->filled('organizador_id')) {

            $query->where(
                'organizador_id',
                $request->organizador_id
            );

        }

        // 🔥 ORDEN FECHA
        $rodadas = $query
            ->orderBy('fecha', 'asc')
            ->get();

        return response()->json(

            $rodadas->map(function($rodada) {

                return [

                    'id' => $rodada->id,

                    'title' => $rodada->titulo,

                    'start' => $rodada->fecha->format('Y-m-d'),

                    // 🔥 FULLCALENDAR
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