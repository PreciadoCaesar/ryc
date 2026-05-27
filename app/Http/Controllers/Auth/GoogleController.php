<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\WelcomeMail;
use App\Models\Advisor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
            
            // Buscar usuario por google_id o email
            $user = User::where('google_id', $googleUser->id)
                        ->orWhere('email', $googleUser->email)
                        ->first();
            
            if (!$user) {
                // Usuario NO existe: crear cuenta nueva
                // Si es correo corporativo @rc-consulting.org, asignar rol desarrollador (admin)
                $rol = str_ends_with($googleUser->email, '@rc-consulting.org') ? 'desarrollador' : 'usuario';
                
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'avatar' => $googleUser->avatar,
                    'rol' => $rol,
                    'password' => bcrypt(uniqid()),
                ]);

                Mail::to($user->email)->send(new WelcomeMail($user->name));
            } else {
                // Actualizar google_id si no lo tiene
                if (empty($user->google_id)) {
                    $user->update(['google_id' => $googleUser->id]);
                }
                // Actualizar avatar si cambió
                if ($user->avatar !== $googleUser->avatar) {
                    $user->update(['avatar' => $googleUser->avatar]);
                }
            }

            // Vincular con advisor si el email coincide
            if (empty($user->advisor_id)) {
                $advisor = Advisor::where('email', $user->email)->first();
                if ($advisor) {
                    $user->update(['advisor_id' => $advisor->id]);
                }
            }
            
            // Login y regenerar sesión
            Auth::login($user, true);
            request()->session()->regenerate();
            
            // Log para debug
            \Illuminate\Support\Facades\Log::info('Login exitoso', [
                'user_id' => $user->id,
                'email' => $user->email,
                'rol' => $user->rol,
                'is_rc' => str_ends_with($user->email, '@rc-consulting.org'),
                'session_id' => request()->session()->getId(),
            ]);
            
            // Redirección según rol
            if (in_array($user->rol, ['dios', 'desarrollador', 'gerente', 'asesora'])) {
                return redirect()->to('/admin/dashboard');
            } else {
                return redirect()->to('/');
            }
            
        } catch (\Exception $e) {
            return redirect('/')->with('error', 'Error en la autenticación: ' . $e->getMessage());
        }
    }

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        
        return redirect('/');
    }
}
