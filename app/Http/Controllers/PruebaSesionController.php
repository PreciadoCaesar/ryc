<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PruebaSesionController extends Controller
{
    public function showLogin()
    {
        return view('prueba-sesion');
    }

    public function login(Request $request)
    {
        $request->validate([
            'usuario' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('name', $request->usuario)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user, $request->boolean('remember'));
            $request->session()->regenerate();

            if (in_array($user->rol, ['dios', 'desarrollador', 'gerente', 'asesora'])) {
                return redirect()->to('/admin/dashboard');
            }

            return redirect()->intended('/perfil');
        }

        return back()->withErrors([
            'usuario' => 'Credenciales incorrectas.',
        ])->onlyInput('usuario');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/pruebasesion');
    }
}
