<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Advisor;
use App\Models\Professor;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    public function catalogoCursos()
    {
        $cursos = Course::where('type', 'curso')
            ->where('mode', 'grabado')
            ->where(function ($q) {
                $q->where('status', 'activo')->orWhereNull('status');
            })
            ->orderBy('title')
            ->get();

        return view('cursos-virtuales', compact('cursos'));
    }

    public function catalogoDiplomas()
    {
        $cursos = Course::where('type', 'diplomado')
            ->where('mode', 'grabado')
            ->where(function ($q) {
                $q->where('status', 'activo')->orWhereNull('status');
            })
            ->orderBy('title')
            ->get();

        return view('diplomas-virtuales', compact('cursos'));
    }

    public function mostrar($slug)
    {
        $curso = Course::where('slug', $slug)->with(['advisor', 'profesores', 'objetivos', 'participantes', 'temario', 'page'])->firstOrFail();

        return view('cursos.landing', compact('curso'));
    }

    public function formulario()
    {
        return redirect()->route('cursos.create');
    }

    public function create()
    {
        $asesoras = Advisor::asesoras()->get();
        $asesoresInhouse = Advisor::inhouse()->get();
        $profesores = Professor::all();
        return view('admin.cursos.form', compact('asesoras', 'asesoresInhouse', 'profesores'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'type' => 'required|string',
            'mode' => 'nullable|string|in:en_vivo,grabado',
            'subtitle' => 'nullable|string',
            'phrase' => 'nullable|string',
            'description' => 'nullable|string',
            'start_date' => 'nullable|string',
            'slug' => 'nullable|string',
            'sessions' => 'nullable|integer',
            'hours' => 'nullable|integer',
            'link_brochure' => 'nullable|string',
            'link_niubiz' => 'nullable|string',
            'specialization_name' => 'nullable|string',
            'image_promotion' => 'nullable',
            'inhouse_web' => 'nullable',
            'inhouse_mobile' => 'nullable',
            'precio_flash_fecha' => 'nullable|string',
            'precio_flash' => 'nullable|numeric',
            'precio_regular' => 'nullable|numeric',
            'precio_pronto_fecha' => 'nullable|string',
            'precio_pronto' => 'nullable|numeric',
            'seo_title' => 'nullable|string',
            'seo_description' => 'nullable|string',
            'seo_keywords' => 'nullable|string',
            'status' => 'nullable|string',
            'objetivos' => 'nullable|array',
            'participantes' => 'nullable|array',
            'sesiones' => 'nullable|array',
            'asesora_id' => 'nullable|exists:advisors,id',
            'asesor_inhouse_id' => 'nullable|exists:advisors,id',
            'profesor_ids' => 'nullable|array',
            'profesor_ids.*' => 'exists:professors,id',
            'fecha_limite_oferta' => 'nullable|string',
            'fecha_inicio_iso' => 'nullable|string',
            'tipo_certificado' => 'nullable|string',
            'temario_titulo' => 'nullable|string',
            'temario_hierarchical' => 'nullable|string',
            'url_video_vimeo' => 'nullable|string',
            'og_image_url' => 'nullable|string',
            'descripcion_inhouse' => 'nullable|string',
        ]);

        $data['slug'] = $request->slug ?: \Illuminate\Support\Str::slug($request->title);
        
        // Handle duplicate slug
        $existingSlug = Course::where('slug', $data['slug'])->where('id', '!=', $request->route('curso'))->first();
        if ($existingSlug) {
            $data['slug'] = $data['slug'] . '-' . time();
        }

        // Temario hierarchical as JSON
        if ($request->filled('temario_hierarchical')) {
            $decoded = json_decode($request->temario_hierarchical, true);
            if (is_array($decoded)) {
                $data['temario_hierarchical'] = $decoded;
            }
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

        // Sync profesores
        if ($request->has('profesor_ids')) {
            $curso->profesores()->sync($request->profesor_ids);
        }

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

        // Save sesiones (temario)
        if ($request->has('sesiones')) {
            foreach ($request->sesiones as $index => $ses) {
                if (!empty($ses['titulo'])) {
                    $temas = [];
                    if (!empty($ses['temas'])) {
                        $temas = array_map('trim', explode("\n", str_replace("\r\n", "\n", $ses['temas'])));
                        $temas = array_filter($temas);
                    }
                    
                    $curso->temario()->create([
                        'numero' => $index + 1,
                        'titulo' => $ses['titulo'] ?? '',
                        'temas' => array_values($temas),
                    ]);
                }
            }
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
        $curso = Course::with(['objetivos', 'participantes', 'temario', 'profesores', 'page'])->findOrFail($id);
        $asesoras = Advisor::asesoras()->get();
        $asesoresInhouse = Advisor::inhouse()->get();
        $profesores = Professor::all();
        
        return view('admin.cursos.form', compact('curso', 'asesoras', 'asesoresInhouse', 'profesores'));
    }

    public function update(Request $request, $id)
    {
        $curso = Course::with(['objetivos', 'participantes', 'temario'])->findOrFail($id);
        
        $data = $request->validate([
            'title' => 'required|string',
            'type' => 'required|string',
            'mode' => 'nullable|string|in:en_vivo,grabado',
            'subtitle' => 'nullable|string',
            'phrase' => 'nullable|string',
            'description' => 'nullable|string',
            'start_date' => 'nullable|string',
            'slug' => 'nullable|string',
            'sessions' => 'nullable|integer',
            'hours' => 'nullable|integer',
            'link_brochure' => 'nullable|string',
            'link_niubiz' => 'nullable|string',
            'specialization_name' => 'nullable|string',
            'image_promotion' => 'nullable',
            'inhouse_web' => 'nullable',
            'inhouse_mobile' => 'nullable',
            'precio_flash_fecha' => 'nullable|string',
            'precio_flash' => 'nullable|numeric',
            'precio_regular' => 'nullable|numeric',
            'precio_pronto_fecha' => 'nullable|string',
            'precio_pronto' => 'nullable|numeric',
            'seo_title' => 'nullable|string',
            'seo_description' => 'nullable|string',
            'seo_keywords' => 'nullable|string',
            'status' => 'nullable|string',
            'objetivos' => 'nullable|array',
            'participantes' => 'nullable|array',
            'sesiones' => 'nullable|array',
            'asesora_id' => 'nullable|exists:advisors,id',
            'asesor_inhouse_id' => 'nullable|exists:advisors,id',
            'profesor_ids' => 'nullable|array',
            'profesor_ids.*' => 'exists:professors,id',
            'fecha_limite_oferta' => 'nullable|string',
            'fecha_inicio_iso' => 'nullable|string',
            'tipo_certificado' => 'nullable|string',
            'temario_titulo' => 'nullable|string',
            'temario_hierarchical' => 'nullable|string',
            'url_video_vimeo' => 'nullable|string',
            'og_image_url' => 'nullable|string',
            'descripcion_inhouse' => 'nullable|string',
        ]);

        // Temario hierarchical as JSON
        if ($request->filled('temario_hierarchical')) {
            $decoded = json_decode($request->temario_hierarchical, true);
            if (is_array($decoded)) {
                $data['temario_hierarchical'] = $decoded;
            }
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

        $curso->update($data);

        // Sync profesores
        if ($request->has('profesor_ids')) {
            $curso->profesores()->sync($request->profesor_ids);
        }

        // Update objetivos - delete & recreate
        $curso->objetivos()->delete();
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

        // Update participantes
        $curso->participantes()->delete();
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

        // Update sesiones (temario)
        $curso->temario()->delete();
        if ($request->has('sesiones')) {
            foreach ($request->sesiones as $index => $ses) {
                if (!empty($ses['titulo'])) {
                    $temas = [];
                    if (!empty($ses['temas'])) {
                        $temas = array_map('trim', explode("\n", str_replace("\r\n", "\n", $ses['temas'])));
                        $temas = array_filter($temas);
                    }
                    
                    $curso->temario()->create([
                        'numero' => $index + 1,
                        'titulo' => $ses['titulo'] ?? '',
                        'temas' => array_values($temas),
                    ]);
                }
            }
        }

        return redirect()->route('curso.mostrar', $curso->slug)->with('success', 'Curso actualizado exitosamente');
    }

    private function buildPageContent(Request $request): array
    {
        $content = [];

        if ($request->filled('video_url')) {
            $content['video_url'] = $request->video_url;
        }

        if ($request->filled('schedule')) {
            $content['schedule'] = $request->schedule;
        }

        if ($request->has('testimonios') && is_array($request->testimonios)) {
            $filtered = array_filter($request->testimonios, fn($t) => !empty($t['nombre'] ?? $t['texto'] ?? ''));
            if (!empty($filtered)) {
                $content['testimonios'] = array_values($filtered);
            }
        }

        if ($request->has('faq') && is_array($request->faq)) {
            $filtered = array_filter($request->faq, fn($f) => !empty($f['pregunta'] ?? ''));
            if (!empty($filtered)) {
                $content['faq'] = array_values($filtered);
            }
        }

        if ($request->has('diferenciadores') && is_array($request->diferenciadores)) {
            $filtered = array_filter($request->diferenciadores, fn($d) => !empty($d['titulo'] ?? ''));
            if (!empty($filtered)) {
                $content['diferenciadores'] = array_values($filtered);
            }
        }

        if ($request->filled('seo_title')) {
            $content['seo_title'] = $request->seo_title;
        }
        if ($request->filled('seo_description')) {
            $content['seo_description'] = $request->seo_description;
        }

        if ($request->filled('temario_hierarchical')) {
            $decoded = json_decode($request->temario_hierarchical, true);
            if (is_array($decoded)) {
                $content['temario_hierarchical'] = $decoded;
            }
        }

        return $content;
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