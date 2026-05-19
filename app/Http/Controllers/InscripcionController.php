<?php

namespace App\Http\Controllers;

use App\Models\Inscripcion;
use App\Models\Rodada;
use App\Models\Usuario;
use App\Models\Organizador;
use Illuminate\Http\Request;

class InscripcionController extends Controller
{
    public function index(Request $request)
    {
        // ADMIN
        if (auth()->user()->rol === 'admin') {

            if ($request->has('rodada_id')) {
                $datos['inscripciones'] = Inscripcion::with(['usuario','rodada'])
                    ->where('rodada_id', $request->rodada_id)
                    ->paginate(10);
            } else {
                $datos['inscripciones'] = Inscripcion::with(['usuario','rodada'])
                    ->paginate(10);
            }

        // ORGANIZADOR
        } elseif (auth()->user()->rol === 'organizador') {

            $organizador = Organizador::where('email', auth()->user()->email)->first();

            $datos['inscripciones'] = Inscripcion::with(['usuario','rodada'])
                ->whereHas('rodada', function ($query) use ($organizador) {
                    $query->where('organizador_id', $organizador->id);
                })
                ->paginate(10);

        // USUARIO NORMAL
        } else {

            $datos['inscripciones'] = Inscripcion::with(['usuario','rodada'])
                ->where('usuario_id', auth()->user()->id)
                ->paginate(10);
        }

        return view('inscripciones.index', $datos);
    }

    public function create()
    {
        $rodadas = Rodada::all();

        // ⚠️ ya NO usamos usuarios en el form
        return view('inscripciones.create', compact('rodadas'));
    }

    public function store(Request $request)
    {
        $campos = [
            'estado' => 'required|in:inscrito,no_inscrito',
            'fecha' => 'required|date',
            'rodada_id' => 'required|exists:rodadas,id'
        ];

        $this->validate($request, $campos);

        $usuarioId = auth()->user()->id;

        $existe = Inscripcion::where('usuario_id', $usuarioId)
            ->where('rodada_id', $request->rodada_id)
            ->exists();

        if ($existe) {
            return redirect()->back()->with('mensaje', 'Ya estás inscrito en esta rodada');
        }

        Inscripcion::create([
            'usuario_id' => $usuarioId,
            'rodada_id' => $request->rodada_id,
            'estado' => $request->estado,
            'fecha' => $request->fecha,
        ]);

        return redirect()->back()->with('mensaje', 'Inscripción realizada');
    }

    public function edit($id)
    {
        $inscripcion = Inscripcion::findOrFail($id);
        $rodadas = Rodada::all();

        return view('inscripciones.edit', compact('inscripcion','rodadas'));
    }

    public function update(Request $request, $id)
    {
        $campos = [
            'estado'=> 'required|in:inscrito,no_inscrito',
            'fecha'=>'required|date'
        ];

        $this->validate($request,$campos);

        $datos = $request->only(['estado','fecha','rodada_id']);

        Inscripcion::where('id', $id)->update($datos);

        return redirect('inscripciones')->with('mensaje','Inscripción modificada.');
    }

    public function destroy($id)
    {
        Inscripcion::destroy($id);

        return redirect('inscripciones')->with('mensaje','Inscripción cancelada correctamente.');
    }
}