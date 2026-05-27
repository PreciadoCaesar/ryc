<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CoursePage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with(['professor', 'advisor'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($courses);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|string',
            'hours' => 'integer',
            'link' => 'required|string',
            'color' => 'string',
            'type' => 'required|in:curso,diplomado',
            'mode' => 'required|in:en_vivo,grabado',
            'featured' => 'boolean',
            'overlay_html' => 'nullable|string',
            'sesiones' => 'nullable|integer',
            'fecha_inicio' => 'nullable|string',
            'professor_id' => 'nullable|exists:professors,id',
            'advisor_id' => 'nullable|exists:advisors,id',
        ]);

        $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(6);
        $validated['featured'] = $validated['featured'] ?? false;

        $course = Course::create($validated);

        return response()->json($course, 201);
    }

    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'image' => 'sometimes|string',
            'hours' => 'sometimes|integer',
            'link' => 'sometimes|string',
            'color' => 'sometimes|string',
            'type' => 'sometimes|in:curso,diplomado',
            'mode' => 'sometimes|in:en_vivo,grabado',
            'featured' => 'sometimes|boolean',
            'overlay_html' => 'nullable|string',
            'sesiones' => 'nullable|integer',
            'fecha_inicio' => 'nullable|string',
            'professor_id' => 'nullable|exists:professors,id',
            'advisor_id' => 'nullable|exists:advisors,id',
        ]);

        if (isset($validated['title']) && $validated['title'] !== $course->title) {
            $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(6);
        }

        $course->update($validated);

        return response()->json($course);
    }

    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();

        return response()->json(['message' => 'Curso eliminado']);
    }

    public function savePage(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        $validated = $request->validate([
            'content' => 'required|array',
        ]);

        $page = $course->page()->updateOrCreate(
            ['course_id' => $id],
            ['content' => $validated['content']]
        );

        return response()->json($page);
    }
}
