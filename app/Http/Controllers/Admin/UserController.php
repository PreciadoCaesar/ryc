<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advisor;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('advisor')->orderBy('created_at', 'desc')->get();
        return view('admin.users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'rol' => 'required|in:usuario,asesora,gerente,desarrollador,dios',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'rol' => $validated['rol'],
            'password' => bcrypt(uniqid()),
        ]);

        if ($validated['rol'] === 'asesora') {
            $advisor = Advisor::firstOrCreate(
                ['email' => $validated['email']],
                [
                    'name' => $validated['name'],
                    'whatsapp' => '999999999',
                    'cargo' => 'Asesora',
                ]
            );
            $user->update(['advisor_id' => $advisor->id]);
        }

        return redirect()->route('admin.users.index')->with('success', 'Usuario creado correctamente');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'rol' => 'required|in:usuario,asesora,gerente,desarrollador,dios',
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'rol' => $validated['rol'],
        ]);

        if ($validated['rol'] === 'asesora' && empty($user->advisor_id)) {
            $advisor = Advisor::firstOrCreate(
                ['email' => $validated['email']],
                [
                    'name' => $validated['name'],
                    'whatsapp' => '999999999',
                    'cargo' => 'Asesora',
                ]
            );
            $user->update(['advisor_id' => $advisor->id]);
        }

        return redirect()->route('admin.users.index')->with('success', 'Usuario actualizado correctamente');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Usuario eliminado correctamente');
    }
}
