<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lead;
use App\Models\Advisor;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = Lead::with('advisor');

        // Si el rol es asesora, filtrar solo sus leads
        if (in_array($user->rol, ['asesora'])) {
            $asesora = $user->advisor;
            if ($asesora) {
                $courseTitles = Course::where('advisor_id', $asesora->id)
                    ->orWhere('asesora_id', $asesora->id)
                    ->pluck('title');
                $query->where(function ($q) use ($courseTitles, $asesora) {
                    $q->whereIn('curso', $courseTitles)
                      ->orWhere('advisor_id', $asesora->id);
                });
            } else {
                $leads = collect();
                $asesoras = Advisor::orderBy('name')->get();
                $todosCursos = collect();
                return view('admin.leads.index', compact('leads', 'asesora', 'asesoras', 'todosCursos'));
            }
        } else {
            // Admin / gerente / dios: filtros por asesor y curso
            if ($request->filled('asesora_id')) {
                $asesoraFiltro = Advisor::find($request->asesora_id);
                if ($asesoraFiltro) {
                    $courseTitles = Course::where('advisor_id', $asesoraFiltro->id)
                        ->orWhere('asesora_id', $asesoraFiltro->id)
                        ->pluck('title');
                    $query->where(function ($q) use ($courseTitles, $asesoraFiltro) {
                        $q->whereIn('curso', $courseTitles)
                          ->orWhere('advisor_id', $asesoraFiltro->id);
                    });
                }
            }

            if ($request->filled('curso')) {
                $query->where('curso', $request->curso);
            }
        }

        $leads = $query->orderBy('created_at', 'desc')->get();

        $asesora = $user->advisor ?? null;
        $asesoras = Advisor::orderBy('name')->get();
        $todosCursos = Lead::select('curso')->distinct()->pluck('curso')->sort();

        return view('admin.leads.index', compact('leads', 'asesora', 'asesoras', 'todosCursos'));
    }

    public function exportExcel($advisorId = null)
    {
        $asesora = Advisor::findOrFail($advisorId);
        $leads = Lead::where('advisor_id', $advisorId)->orderBy('created_at', 'desc')->get();

        $filename = 'leads_' . str_replace(' ', '_', $asesora->name) . '_' . date('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($leads) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($file, ['ID', 'Nombre', 'Celular', 'Correo', 'Consulta', 'Curso', 'Asesora', 'Status', 'WhatsApp', 'Fecha', 'Contactado', 'Tiempo Respuesta', 'Rápido (≤6min)'], ';', '"');

            foreach ($leads as $lead) {
                $contactedAt = $lead->contacted_at ? $lead->contacted_at->format('Y-m-d H:i') : '';
                $tiempoRespuesta = $lead->tiempo_respuesta ?? '';
                $rapido = $lead->respuesta_rapida ? 'Sí' : 'No';

                fputcsv($file, [
                    $lead->id,
                    $lead->nombre,
                    $lead->celular,
                    $lead->correo,
                    $lead->consulta,
                    $lead->curso,
                    $lead->advisor?->name ?? '',
                    $lead->status,
                    $lead->is_whatsapp ? 'Sí' : 'No',
                    $lead->created_at->format('Y-m-d H:i'),
                    $contactedAt,
                    $tiempoRespuesta,
                    $rapido,
                ], ';', '"');
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportExcelByCourse($courseName)
    {
        $courseName = urldecode($courseName);
        $leads = Lead::where('curso', $courseName)->with('advisor')->orderBy('created_at', 'desc')->get();

        $filename = 'leads_' . str_replace(' ', '_', $courseName) . '_' . date('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($leads) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($file, ['ID', 'Nombre', 'Celular', 'Correo', 'Consulta', 'Curso', 'Asesora', 'Status', 'WhatsApp', 'Fecha', 'Contactado', 'Tiempo Respuesta', 'Rápido (≤6min)'], ';', '"');

            foreach ($leads as $lead) {
                $contactedAt = $lead->contacted_at ? $lead->contacted_at->format('Y-m-d H:i') : '';
                $tiempoRespuesta = $lead->tiempo_respuesta ?? '';
                $rapido = $lead->respuesta_rapida ? 'Sí' : 'No';

                fputcsv($file, [
                    $lead->id,
                    $lead->nombre,
                    $lead->celular,
                    $lead->correo,
                    $lead->consulta,
                    $lead->curso,
                    $lead->advisor?->name ?? '',
                    $lead->status,
                    $lead->is_whatsapp ? 'Sí' : 'No',
                    $lead->created_at->format('Y-m-d H:i'),
                    $contactedAt,
                    $tiempoRespuesta,
                    $rapido,
                ], ';', '"');
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:ingreso,contacto,venta cerrada,no interesado,respondido',
        ]);

        $lead = Lead::findOrFail($id);

        // Si cambia a contacto, registrar contacted_at (solo si no estaba ya en contacto)
        if ($request->status === 'contacto' && $lead->status !== 'contacto' && !$lead->contacted_at) {
            $lead->contacted_at = now();
        }

        $lead->status = $request->status;
        $lead->save();

        if ($request->status === 'venta cerrada') {
            $course = Course::where('title', $lead->curso)->first();
            $user = $lead->correo ? User::where('email', $lead->correo)->first() : null;

            if ($course && $user) {
                $exists = Purchase::where('user_id', $user->id)
                    ->where('course_id', $course->id)
                    ->exists();

                if (!$exists) {
                    Purchase::create([
                        'user_id' => $user->id,
                        'course_id' => $course->id,
                        'status' => 'activo',
                        'purchased_at' => now(),
                    ]);
                }
            }
        }

        return response()->json(['success' => true, 'lead' => $lead]);
    }
}
