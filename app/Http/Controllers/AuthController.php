<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nombre' => 'required|string|max:255',
                'email' => 'required|email|unique:usuarios,email',
                'password' => 'required|string|min:6|confirmed',
                'personas' => 'nullable|integer|min:1'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => 'Datos inválidos',
                    'detalles' => $validator->errors()
                ], 422);
            }

            $usuario = Usuario::create([
                'nombre' => $request->nombre,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'personas' => $request->personas ?? 1,
                'rol' => 'user',
                'perfilCompleto' => false
            ]);

            $token = JWTAuth::fromUser($usuario);

            return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => JWTAuth::factory()->getTTL() * 60,
                'usuario' => [
                    'id' => (string) $usuario->_id,
                    'nombre' => $usuario->nombre,
                    'email' => $usuario->email,
                    'rol' => $usuario->rol,
                    'perfilCompleto' => false
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('Error en register: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'error' => 'Error interno del servidor',
                'message' => config('app.debug') ? $e->getMessage() : 'Por favor intenta de nuevo'
            ], 500);
        }
    }

public function login(Request $request)
{
    try {
        $credentials = $request->only('email', 'password');

        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|string|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Datos inválidos'], 422);
        }

        // Intentar autenticar
        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Credenciales incorrectas'], 401);
        }

        $usuario = auth()->user();

        if (!$usuario) {
            \Log::error('Usuario autenticado pero no encontrado después de JWTAuth::attempt');
            return response()->json(['error' => 'Error al obtener datos del usuario'], 500);
        }

        // Si el campo no existe, lo agregamos
        if (!isset($usuario->perfilCompleto)) {
            $usuario->perfilCompleto = false;
            $usuario->save();
        }

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
            'usuario' => [
                'id' => (string) $usuario->_id,
                'nombre' => $usuario->nombre,
                'email' => $usuario->email,
                'rol' => $usuario->rol,
                'perfilCompleto' => $usuario->perfilCompleto ?? false
            ]
        ]);

    } catch (\Exception $e) {
        \Log::error('Error en login: ' . $e->getMessage());
        \Log::error('Stack trace: ' . $e->getTraceAsString());
        return response()->json([
            'error' => 'Error interno del servidor',
            'message' => config('app.debug') ? $e->getMessage() : 'Por favor intenta de nuevo'
        ], 500);
    }
}


    public function me()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Sesión cerrada']);
    }
}
