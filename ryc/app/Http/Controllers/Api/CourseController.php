<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $query = Course::with(['professor', 'advisor']);

        if ($request->has('type')) {
            $query->type($request->type);
        }

        if ($request->has('mode')) {
            $query->mode($request->mode);
        }

        $courses = $query->orderBy('featured', 'desc')
            ->orderBy('fecha_inicio')
            ->get();

        return response()->json($courses);
    }

    public function featured()
    {
        $courses = Course::with(['professor', 'advisor'])
            ->featured()
            ->orderBy('fecha_inicio')
            ->get();

        return response()->json($courses);
    }

    public function show($slug)
    {
        $course = Course::with(['professor', 'advisor', 'page'])
            ->where('slug', $slug)
            ->firstOrFail();

        return response()->json($course);
    }

    public function page($slug)
    {
        $course = Course::where('slug', $slug)->firstOrFail();
        $page = $course->page;

        if (!$page) {
            return response()->json(['content' => null]);
        }

        return response()->json($page);
    }
}
