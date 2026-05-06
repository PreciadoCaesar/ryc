<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Advisor;
use App\Models\Professor;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    public function mostrar($slug)
    {
        $curso = Course::where('slug', $slug)->with(['advisor', 'profesores', 'objetivos', 'participantes', 'temario'])->firstOrFail();
        
        return view('cursos.mostrar', compact('curso'));
    }

    public function formulario()
    {
        $asesoras = Advisor::all();
        $profesores = Professor::all();
        
        return view('cursos.formulario', compact('asesoras', 'profesores'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'type' => 'required|string',
            'subtitle' => 'nullable|string',
            'phrase' => 'nullable|string',
            'description' => 'nullable|string',
            'start_date' => 'nullable|string',
            'sessions' => 'nullable|integer',
            'hours' => 'nullable|integer',
            'advisor_id' => 'nullable|exists:advisors,id',
            'link_brochure' => 'nullable|url',
            'link_niubiz' => 'nullable|url',
            'specialization_name' => 'nullable|string',
            'image_promotion' => 'nullable|string',
            'inhouse_web' => 'nullable|string',
            'inhouse_mobile' => 'nullable|string',
            'precio_flash_fecha' => 'nullable|string',
            'precio_flash' => 'nullable|numeric',
            'precio_regular' => 'nullable|numeric',
            'precio_pronto_fecha' => 'nullable|string',
            'precio_pronto' => 'nullable|numeric',
            'seo_title' => 'nullable|string',
            'seo_description' => 'nullable|string',
            'seo_keywords' => 'nullable|string',
            'objetivos' => 'nullable|array',
            'participantes' => 'nullable|array',
            'temario' => 'nullable|array',
            'profesores' => 'nullable|array',
        ]);

        $data['slug'] = \Illuminate\Support\Str::slug($request->title);
        
        // Handle duplicate slug
        $existingSlug = Course::where('slug', $data['slug'])->first();
        if ($existingSlug) {
            $data['slug'] = $data['slug'] . '-' . time();
        }

        // Manejar subida de imágenes
        if ($request->hasFile('image_promotion')) {
            $file = $request->file('image_promotion');
            $filename = time() . '_promocion.' . $file->getClientOriginalExtension();
            $file->move(public_path('img/promocion'), $filename);
            $data['image_promotion'] = 'img/promocion/' . $filename;
        }

        if ($request->hasFile('inhouse_web')) {
            $file = $request->file('inhouse_web');
            $filename = time() . '_inhouse_web.' . $file->getClientOriginalExtension();
            $file->move(public_path('img/inhouse'), $filename);
            $data['inhouse_web'] = 'img/inhouse/' . $filename;
        }

        if ($request->hasFile('inhouse_mobile')) {
            $file = $request->file('inhouse_mobile');
            $filename = time() . '_inhouse_movil.' . $file->getClientOriginalExtension();
            $file->move(public_path('img/inhouse'), $filename);
            $data['inhouse_mobile'] = 'img/inhouse/' . $filename;
        }

        $curso = Course::create($data);

        // Save objetivos
        if ($request->has('objetivos')) {
            foreach ($request->objetivos as $index => $obj) {
                if (!empty($obj['titulo'])) {
                    $curso->objetivos()->create([
                        'titulo' => $obj['titulo'] ?? '',
                        'descripcion' => $obj['descripcion'] ?? '',
                        'orden' => $index + 1,
                    ]);
                }
            }
        }

        // Save participantes
        if ($request->has('participantes')) {
            foreach ($request->participantes as $index => $par) {
                if (!empty($par['descripcion'])) {
                    $curso->participantes()->create([
                        'icono' => $par['icono'] ?? 'fa-user-tie',
                        'descripcion' => $par['descripcion'] ?? '',
                        'orden' => $index + 1,
                    ]);
                }
            }
        }

        // Save temario - convertir temas de texto a array
        if ($request->has('temario')) {
            foreach ($request->temario as $index => $ses) {
                if (!empty($ses['titulo'])) {
                    // Convertir temas de texto separado por comas a array
                    $temas = [];
                    if (!empty($ses['temas_text'])) {
                        $temas = array_map('trim', explode(',', $ses['temas_text']));
                    } elseif (!empty($ses['temas']) && is_array($ses['temas'])) {
                        $temas = $ses['temas'];
                    }
                    
                    $curso->temario()->create([
                        'numero' => $ses['numero'] ?? $index + 1,
                        'titulo' => $ses['titulo'] ?? '',
                        'temas' => $temas,
                    ]);
                }
            }
        }

        // Attach profesores
        if ($request->has('profesores')) {
            $curso->profesores()->attach($request->profesores);
        }

        return redirect()->route('curso.mostrar', $curso->slug)->with('success', 'Curso creado exitosamente');
    }

    public function index()
    {
        $cursos = Course::with(['advisor', 'profesores'])->get();
        return view('cursos.index', compact('cursos'));
    }

    public function edit($id)
    {
        $curso = Course::with(['objetivos', 'participantes', 'temario', 'profesores'])->findOrFail($id);
        $asesoras = Advisor::all();
        $profesores = Professor::all();
        
        return view('cursos.editar', compact('curso', 'asesoras', 'profesores'));
    }

    public function update(Request $request, $id)
    {
        $curso = Course::findOrFail($id);
        
        $data = $request->validate([
            'title' => 'required|string',
            'type' => 'required|string',
            'subtitle' => 'nullable|string',
            'phrase' => 'nullable|string',
            'description' => 'nullable|string',
            'start_date' => 'nullable|string',
            'sessions' => 'nullable|integer',
            'hours' => 'nullable|integer',
            'advisor_id' => 'nullable|exists:advisors,id',
            'link_brochure' => 'nullable|url',
            'link_niubiz' => 'nullable|url',
            'specialization_name' => 'nullable|string',
            'image_promotion' => 'nullable|string',
            'inhouse_web' => 'nullable|string',
            'inhouse_mobile' => 'nullable|string',
            'precio_flash_fecha' => 'nullable|string',
            'precio_flash' => 'nullable|numeric',
            'precio_regular' => 'nullable|numeric',
            'precio_pronto_fecha' => 'nullable|string',
            'precio_pronto' => 'nullable|numeric',
            'seo_title' => 'nullable|string',
            'seo_description' => 'nullable|string',
            'seo_keywords' => 'nullable|string',
            'status' => 'nullable|string',
        ]);

        // Manejar subida de imágenes
        if ($request->hasFile('image_promotion')) {
            $file = $request->file('image_promotion');
            $filename = time() . '_promocion.' . $file->getClientOriginalExtension();
            $file->move(public_path('img/promocion'), $filename);
            $data['image_promotion'] = 'img/promocion/' . $filename;
        }

        if ($request->hasFile('inhouse_web')) {
            $file = $request->file('inhouse_web');
            $filename = time() . '_inhouse_web.' . $file->getClientOriginalExtension();
            $file->move(public_path('img/inhouse'), $filename);
            $data['inhouse_web'] = 'img/inhouse/' . $filename;
        }

        if ($request->hasFile('inhouse_mobile')) {
            $file = $request->file('inhouse_mobile');
            $filename = time() . '_inhouse_movil.' . $file->getClientOriginalExtension();
            $file->move(public_path('img/inhouse'), $filename);
            $data['inhouse_mobile'] = 'img/inhouse/' . $filename;
        }

        $curso->update($data);

        // Update objetivos
        $curso->objetivos()->delete();
        if ($request->has('objetivos')) {
            foreach ($request->objetivos as $index => $obj) {
                $curso->objetivos()->create([
                    'titulo' => $obj['titulo'] ?? '',
                    'descripcion' => $obj['descripcion'] ?? '',
                    'orden' => $index + 1,
                ]);
            }
        }

        // Update participantes
        $curso->participantes()->delete();
        if ($request->has('participantes')) {
            foreach ($request->participantes as $index => $par) {
                $curso->participantes()->create([
                    'icono' => $par['icono'] ?? 'fa-user-tie',
                    'descripcion' => $par['descripcion'] ?? '',
                    'orden' => $index + 1,
                ]);
            }
        }

        // Update temario
        $curso->temario()->delete();
        if ($request->has('temario')) {
            foreach ($request->temario as $index => $ses) {
                $curso->temario()->create([
                    'numero' => $ses['numero'] ?? $index + 1,
                    'titulo' => $ses['titulo'] ?? '',
                    'temas' => $ses['temas'] ?? [],
                ]);
            }
        }

        // Update profesores
        $curso->profesores()->detach();
        if ($request->has('profesores')) {
            $curso->profesores()->attach($request->profesores);
        }

        return redirect()->route('curso.mostrar', $curso->slug)->with('success', 'Curso actualizado');
    }

    public function destroy($id)
    {
        $curso = Course::findOrFail($id);
        $curso->objetivos()->delete();
        $curso->participantes()->delete();
        $curso->temario()->delete();
        $curso->profesores()->detach();
        $curso->delete();

        return redirect()->route('cursos.index')->with('success', 'Curso eliminado');
    }
}