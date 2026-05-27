<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $purchases = $user->purchases()->with('course')->orderBy('created_at', 'desc')->get();

        return view('profile.index', compact('user', 'purchases'));
    }
}
