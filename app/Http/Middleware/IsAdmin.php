<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        try {
            $user = $request->user();
            
            if (!$user) {
                \Log::warning('Intento de acceso a ruta admin sin autenticación');
                return response()->json([
                    'message' => 'Usuario no autenticado'
                ], 401);
            }

            if ($user->rol !== 'admin') {
                \Log::warning('Usuario no admin intentando acceder a ruta admin: ' . $user->email);
                return response()->json([
                    'message' => 'No tienes permisos de administrador'
                ], 403);
            }

            return $next($request);
        } catch (\Exception $e) {
            \Log::error('Error en middleware IsAdmin: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            return response()->json([
                'message' => 'Error en la verificación de permisos',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
