<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;

class UsuarioController extends Controller
{
    // Admin methods
    public function index()
    {
        try {
            $users = Usuario::all();
            return response()->json(['users' => $users]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener usuarios'], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nombre' => 'required|string|max:255',
                'email' => 'required|email|unique:usuarios,email',
                'password' => 'required|string|min:6',
                'rol' => 'required|in:user,admin'
            ]);

            $usuario = new Usuario();
            $usuario->nombre = $validated['nombre'];
            $usuario->email = $validated['email'];
            $usuario->password = bcrypt($validated['password']);
            $usuario->rol = $validated['rol'];
            $usuario->save();

            return response()->json(['user' => $usuario], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al crear usuario', 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $usuario = Usuario::find($id);
            
            if (!$usuario) {
                return response()->json(['error' => 'Usuario no encontrado'], 404);
            }

            $validated = $request->validate([
                'nombre' => 'required|string|max:255',
                'email' => 'required|email|unique:usuarios,email,' . $id . ',_id',
                'rol' => 'required|in:user,admin'
            ]);

            $usuario->nombre = $validated['nombre'];
            $usuario->email = $validated['email'];
            $usuario->rol = $validated['rol'];
            
            if ($request->has('password') && !empty($request->password)) {
                $usuario->password = bcrypt($request->password);
            }

            $usuario->save();

            return response()->json(['user' => $usuario]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al actualizar usuario', 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $usuario = Usuario::find($id);
            
            if (!$usuario) {
                return response()->json(['error' => 'Usuario no encontrado'], 404);
            }

            $usuario->delete();
            return response()->json(['message' => 'Usuario eliminado correctamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar usuario'], 500);
        }
    }
    // Guardar alergias
    public function guardarAlergias(Request $request)
    {
        $usuario = Usuario::find($request->user()->_id);
        $usuario->alergias = $request->input('alergias');
        $usuario->save();

        return response()->json(['message' => 'Alergias guardadas']);
    }

    // Actualizar número de personas
    public function actualizarPersonas(Request $request)
    {
        $usuario = Usuario::find($request->user()->_id);
        $usuario->personas = $request->input('personas');
        $usuario->save();

        return response()->json(['message' => 'Número de personas actualizado']);
    }

    // Obtener preferencias del usuario
    public function getPreferencias(Request $request)
    {
        $usuario = Usuario::find($request->user()->_id);

        return response()->json([
            'alergias' => $usuario->alergias,
            'personas' => $usuario->personas,
            'recetas_guardadas' => $usuario->recetas_guardadas
        ]);
    }

public function yo(Request $request)
{
    $usuario = $request->user();

    if (!$usuario || !isset($usuario->_id)) {
        return response()->json(['error' => 'Usuario no autenticado'], 401);
    }

    return response()->json([
        'nombre' => $usuario->nombre,
        'email' => $usuario->email,
        'rol' => $usuario->rol,
        'alergias' => $usuario->alergias ?? [],
        'preferencias' => $usuario->preferencias ?? [],
        'metaCalorias' => $usuario->metaCalorias ?? 0,
        'perfilCompleto' => $usuario->perfilCompleto ?? false,
        'recetas_guardadas' => $usuario->recetas_guardadas ?? [],
        'personas' => $usuario->personas ?? 1
    ]);
}






public function actualizarPerfil(Request $request)
{
    try {
        $usuario = $request->user();

        if (!$usuario || !isset($usuario->_id)) {
            return response()->json(['error' => 'Usuario no autenticado o ID no disponible'], 401);
        }

        $validated = $request->validate([
            'metaCalorias' => 'nullable|integer|min:8400|max:28000', // Valores semanales
            'preferencias' => 'nullable|array',
            'alergias' => 'nullable|array'
        ]);

        // Asignar valores
        $usuario->metaCalorias = $validated['metaCalorias'] ?? null;
        $usuario->preferencias = $validated['preferencias'] ?? [];
        $usuario->alergias = $validated['alergias'] ?? [];

        // Marcar perfil como completo si todos los campos están presentes
        $usuario->perfilCompleto = (
            !empty($usuario->metaCalorias) &&
            !empty($usuario->preferencias) &&
            !empty($usuario->alergias)
        );

        $usuario->save();

        return response()->json([
            'message' => 'Perfil actualizado correctamente',
            'usuario' => $usuario
        ]);
    } catch (\Exception $e) {
        \Log::error('Error al actualizar perfil: ' . $e->getMessage());

        return response()->json([
            'error' => 'Error interno al actualizar perfil',
            'detalle' => $e->getMessage()
        ], 500);
    }
}

}
