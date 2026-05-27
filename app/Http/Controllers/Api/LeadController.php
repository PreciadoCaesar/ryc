<?php

namespace App\Http\Controllers\Api;

use App\Events\LeadUpdated;
use App\Http\Controllers\Controller;
use App\Mail\LeadNotification;
use App\Models\Course;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        $query = Lead::with('advisor');

        if ($request->has('advisor_id')) {
            $query->where('advisor_id', $request->advisor_id);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('since_id')) {
            $query->where('id', '>', $request->integer('since_id'));
        }

        $leads = $query->orderBy('created_at', 'desc')->get();

        return response()->json($leads);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'celular' => 'required|string|max:20',
            'correo' => 'nullable|email|max:255',
            'consulta' => 'nullable|string',
            'curso' => 'required|string|max:255',
            'origen' => 'nullable|string|max:255',
            'institucion' => 'nullable|string|max:255',
            'cantidadAlumnos' => 'nullable|string|max:50',
            'nivelCurso' => 'nullable|string|max:50',
            'advisor_id' => 'nullable|exists:advisors,id',
        ]);

        $validated['is_whatsapp'] = $this->checkWhatsApp($validated['celular']);
        $validated['status'] = 'ingreso'; // default status when created

        if (isset($validated['cantidadAlumnos'])) {
            $validated['cantidad_alumnos'] = $validated['cantidadAlumnos'];
            unset($validated['cantidadAlumnos']);
        }
        if (isset($validated['nivelCurso'])) {
            $validated['nivel_curso'] = $validated['nivelCurso'];
            unset($validated['nivelCurso']);
        }

        $lead = Lead::create($validated);

        // Vincular al asesor del curso si no se envió advisor_id
        $this->linkAdvisor($lead);

        // Notificar al asesor por email
        $this->notifyAdvisor($lead);

        broadcast(new LeadUpdated($lead))->toOthers();

        return response()->json($lead, 201);
    }

    private function linkAdvisor(Lead $lead): void
    {
        if (!$lead->advisor_id) {
            $course = Course::where('title', $lead->curso)->first();
            if ($course && $course->advisor) {
                $lead->update(['advisor_id' => $course->advisor->id]);
            }
        }
    }

    private function notifyAdvisor(Lead $lead): void
    {
        $advisor = $lead->advisor;

        if ($advisor && $advisor->email) {
            try {
                Mail::to($advisor->email)->send(new LeadNotification($lead, $advisor->name));
            } catch (\Exception $e) {
                \Log::error('Error enviando email de lead: ' . $e->getMessage());
            }
        }
    }

    public function update(Request $request, $id)
    {
        $lead = Lead::findOrFail($id);

        $validated = $request->validate([
            'status' => 'sometimes|in:ingreso,contacto,venta cerrada,no interesado,respondido',
            'is_whatsapp' => 'sometimes|boolean',
        ]);

        // Si cambia a contacto, registrar contacted_at automáticamente
        if (isset($validated['status']) && $validated['status'] === 'contacto' && $lead->status !== 'contacto' && !$lead->contacted_at) {
            $validated['contacted_at'] = now();
        }

        $lead->update($validated);

        broadcast(new LeadUpdated($lead))->toOthers();

        return response()->json($lead);
    }

    public function destroy($id)
    {
        $lead = Lead::findOrFail($id);
        $lead->delete();

        return response()->json(['message' => 'Lead eliminado']);
    }

    private function checkWhatsApp(string $celular): bool
    {
        $clean = preg_replace('/[^0-9]/', '', $celular);
        return strlen($clean) >= 9;
    }
}
