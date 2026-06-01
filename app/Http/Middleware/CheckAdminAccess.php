<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        $adminRoles = ['dios', 'desarrollador', 'gerente', 'asesora'];
        $companyDomain = '@rc-consulting.org';

        // Comparación case-insensitive para el dominio
        $hasCompanyEmail = str_ends_with(strtolower($user->email), strtolower($companyDomain));
        $hasAdminRole = in_array($user->rol, $adminRoles);

        if (!$hasCompanyEmail && !$hasAdminRole) {
            return redirect('/');
        }

        return $next($request);
    }
}
