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
            'primer_nombre' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,webp|max:2048',
            'photo_url' => 'nullable|string|max:500',
            'secciones' => 'nullable|json',
        ]);

        $validated['primer_nombre'] = $request->primer_nombre ?: $this->extractPrimerNombre($request->name);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('profesores', 'public');
        } elseif ($request->filled('photo_url')) {
            $validated['photo'] = $request->photo_url;
        }

        if ($request->filled('secciones')) {
            $decoded = json_decode($request->secciones, true);
            $validated['secciones'] = is_array($decoded) ? $decoded : [];
        } else {
            $validated['secciones'] = [];
        }

        Professor::create($validated);

        return redirect()->route('admin.profesores.index')->with('success', 'Profesor creado correctamente');
    }

    public function update(Request $request, $id)
    {
        $professor = Professor::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'primer_nombre' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,webp|max:2048',
            'photo_url' => 'nullable|string|max:500',
            'secciones' => 'nullable|json',
        ]);

        $validated['primer_nombre'] = $request->primer_nombre ?: $this->extractPrimerNombre($request->name);

        if ($request->hasFile('photo')) {
            if ($professor->photo && !filter_var($professor->photo, FILTER_VALIDATE_URL) && Storage::disk('public')->exists($professor->photo)) {
                Storage::disk('public')->delete($professor->photo);
            }
            $validated['photo'] = $request->file('photo')->store('profesores', 'public');
        } elseif ($request->filled('photo_url')) {
            if ($professor->photo && !filter_var($professor->photo, FILTER_VALIDATE_URL) && Storage::disk('public')->exists($professor->photo)) {
                Storage::disk('public')->delete($professor->photo);
            }
            $validated['photo'] = $request->photo_url;
        }

        if ($request->filled('secciones')) {
            $decoded = json_decode($request->secciones, true);
            $validated['secciones'] = is_array($decoded) ? $decoded : [];
        } else {
            $validated['secciones'] = [];
        }

        $professor->update($validated);

        return redirect()->route('admin.profesores.index')->with('success', 'Profesor actualizado correctamente');
    }

    public function destroy($id)
    {
        $professor = Professor::findOrFail($id);

        if ($professor->photo && !filter_var($professor->photo, FILTER_VALIDATE_URL) && Storage::disk('public')->exists($professor->photo)) {
            Storage::disk('public')->delete($professor->photo);
        }

        $professor->delete();

        return redirect()->route('admin.profesores.index')->with('success', 'Profesor eliminado correctamente');
    }

    private function extractPrimerNombre(string $name): string
    {
        $names = explode(' ', trim($name));
        $skip = ['DR.', 'DR', 'MG.', 'MG', 'MAG.', 'MAG', 'LIC.', 'LIC', 'ING.', 'ING',
                 'BACH.', 'BACH', 'ABOG.', 'ABOG', 'CPA', 'CPC', 'CPCC.', 'CPCC',
                 'MTRO.', 'MTRO', 'PROF.', 'PROF', 'DOC.', 'DOC', 'M.Sc.', 'MSC',
                 'PH.D.', 'PHD', 'DRA.', 'DRA', 'MGA', 'MBA', 'MGP', 'MGR', 'MGT',
                 'BLGA.', 'BLGA', 'BLGO.', 'BLGO', 'CIRUJANO', 'CIRUJANA'];
        foreach ($names as $n) {
            $clean = strtoupper(trim($n));
            if (!in_array($clean, $skip) && !preg_match('/^[A-Z]\.?$/', $clean) && strlen($clean) > 1) {
                return $n;
            }
        }
        return $names[0] ?? '';
    }
}
