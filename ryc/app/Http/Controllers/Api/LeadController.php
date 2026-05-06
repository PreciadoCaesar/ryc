<?php

namespace App\Http\Controllers\Api;

use App\Events\LeadUpdated;
use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\Request;

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
            'advisor_id' => 'nullable|exists:advisors,id',
        ]);

        $validated['is_whatsapp'] = $this->checkWhatsApp($validated['celular']);

        $lead = Lead::create($validated);

        broadcast(new LeadUpdated($lead))->toOthers();

        return response()->json($lead, 201);
    }

    public function update(Request $request, $id)
    {
        $lead = Lead::findOrFail($id);

        $validated = $request->validate([
            'status' => 'sometimes|in:ingreso,contacto,venta cerrada,no interesado',
            'is_whatsapp' => 'sometimes|boolean',
        ]);

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
