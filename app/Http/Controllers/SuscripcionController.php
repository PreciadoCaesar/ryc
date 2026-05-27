<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SuscripcionController extends Controller
{
    /**
     * Mostrar página de suscripciones/membresías
     */
    public function index()
    {
        // Cargar datos desde JSON (futuro: será desde BD)
        $jsonData = File::get(resource_path('data/planes.json'));
        $data = json_decode($jsonData, true);

        $planes = collect($data['planes'])->where('activo', true)->sortBy('orden');
        $financiamiento = $data['financiamiento'];
        $faq = $data['faq'];

        return view('suscripciones.index', compact('planes', 'financiamiento', 'faq'));
    }

    /**
     * Procesar registro de suscripción
     * Por ahora solo simula - futuro: conectar a BD y pasarela de pagos
     */
    public function store(Request $request)
    {
        // Validar datos
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telefono' => 'required|string|max:20',
            'plan_id' => 'required|integer',
            'acepta_politicas' => 'required|accepted'
        ]);

        // Simular respuesta
        // Futuro: 
        // 1. Crear registro en tabla suscripciones
        // 2. Redirigir a pasarela de pagos
        // 3. Webhook confirma pago
        // 4. Enviar email de confirmación

        return response()->json([
            'success' => true,
            'message' => 'Registro recibido correctamente',
            'data' => [
                'nombre' => $validated['nombre'],
                'email' => $validated['email'],
                'plan_id' => $validated['plan_id']
            ],
            'next_step' => 'En producción esto redirige a pasarela de pagos'
        ]);
    }

    /**
     * Confirmar pago (webhook de pasarela)
     * Futuro: recibir confirmación de pasarela de pagos
     */
    public function confirmarPago(Request $request)
    {
        // Futuro: procesar webhook de pasarela
        // 1. Verificar firma de seguridad
        // 2. Actualizar estado de suscripción
        // 3. Enviar email de confirmación
        // 4. Crear acceso en plataforma

        return response()->json([
            'success' => true,
            'message' => 'Pago confirmado'
        ]);
    }
}
