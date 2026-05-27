<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Professor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfessorController extends Controller
{
    public function index()
    {
        $professors = Professor::orderBy('name')->get();
        return view('admin.profesores.index', compact('professors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:webp|max:2048',
            'formacion' => 'nullable|array',
            'formacion.*.titulo' => 'nullable|string',
            'formacion.*.institucion' => 'nullable|string',
            'formacion.*.anio' => 'nullable|string',
            'experiencia' => 'nullable|array',
            'experiencia.*.rol' => 'nullable|string',
            'experiencia.*.empresa' => 'nullable|string',
            'experiencia.*.periodo' => 'nullable|string',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('profesores', 'public');
        }

        Professor::create($validated);

        return redirect()->route('admin.profesores.index')->with('success', 'Profesor creado correctamente');
    }

    public function update(Request $request, $id)
    {
        $professor = Professor::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:webp|max:2048',
            'formacion' => 'nullable|array',
            'formacion.*.titulo' => 'nullable|string',
            'formacion.*.institucion' => 'nullable|string',
            'formacion.*.anio' => 'nullable|string',
            'experiencia' => 'nullable|array',
            'experiencia.*.rol' => 'nullable|string',
            'experiencia.*.empresa' => 'nullable|string',
            'experiencia.*.periodo' => 'nullable|string',
        ]);

        if ($request->hasFile('photo')) {
            if ($professor->photo && Storage::disk('public')->exists($professor->photo)) {
                Storage::disk('public')->delete($professor->photo);
            }
            $validated['photo'] = $request->file('photo')->store('profesores', 'public');
        }

        $professor->update($validated);

        return redirect()->route('admin.profesores.index')->with('success', 'Profesor actualizado correctamente');
    }

    public function destroy($id)
    {
        $professor = Professor::findOrFail($id);

        if ($professor->photo && Storage::disk('public')->exists($professor->photo)) {
            Storage::disk('public')->delete($professor->photo);
        }

        $professor->delete();

        return redirect()->route('admin.profesores.index')->with('success', 'Profesor eliminado correctamente');
    }
}
