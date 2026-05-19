<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Redirección después del registro
     */
    protected $redirectTo = '/calendario';

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Validación del registro
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:usuarios,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Crear usuario en tabla usuarios
     */
    protected function create(array $data)
    {
        return Usuario::create([
            'nombre' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'rol' => 'usuario', // por defecto todos los registros normales serán usuario
        ]);
    }
}