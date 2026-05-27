<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advisor;
use Illuminate\Http\Request;

class AdvisorController extends Controller
{
    public function index()
    {
        $advisors = Advisor::orderBy('created_at', 'desc')->get();
        return view('admin.advisors.index', compact('advisors'));
    }

    public function update(Request $request, $id)
    {
        $advisor = Advisor::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'whatsapp' => 'required|string|max:20',
            'photo' => 'nullable|image|max:2048',
            'photo_web' => 'nullable|image|max:2048',
            'email' => 'nullable|email|max:255',
            'cargo' => 'nullable|string|max:255',
            'tipo' => 'nullable|string|in:asesora,inhouse',
        ]);

        // Auto-add +51 prefix to whatsapp
        $whatsapp = ltrim($validated['whatsapp'], '0');
        if (!str_starts_with($whatsapp, '+')) {
            $whatsapp = str_starts_with($whatsapp, '51') ? '+' . $whatsapp : '+51' . $whatsapp;
        }
        $validated['whatsapp'] = $whatsapp;

        // Handle profile photo upload (sistema)
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_perfil_' . $advisor->id . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('img/advisors'), $filename);
            $validated['photo'] = '/img/advisors/' . $filename;
        } else {
            unset($validated['photo']);
        }

        // Handle web photo upload (página web)
        if ($request->hasFile('photo_web')) {
            $file = $request->file('photo_web');
            $filename = time() . '_web_' . $advisor->id . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('img/advisors'), $filename);
            $validated['photo_web'] = '/img/advisors/' . $filename;
        } else {
            unset($validated['photo_web']);
        }

        $advisor->update($validated);

        return redirect()->route('admin.advisors.index')->with('success', 'Asesora actualizada correctamente');
    }
}
