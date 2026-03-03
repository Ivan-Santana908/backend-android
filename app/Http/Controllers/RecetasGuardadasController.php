<?php

namespace App\Http\Controllers;

use App\Models\RecetaGuardada;
use App\Models\Receta;
use Illuminate\Http\Request;

class RecetasGuardadasController extends Controller
{
    /**
     * 💾 Guardar una receta como favorita
     */
    public function guardar($id, Request $request)
    {
        $usuario = $request->user();

        // Verificar que la receta exista
        $receta = Receta::find($id);
        if (!$receta) {
            return response()->json(['error' => 'Receta no encontrada'], 404);
        }

        // Evitar duplicado
        $existe = RecetaGuardada::where('usuario_id', $usuario->id)
                                ->where('receta_id', $id)
                                ->first();

        if ($existe) {
            return response()->json(['message' => 'Ya está guardada'], 200);
        }

        RecetaGuardada::create([
            'usuario_id' => $usuario->id,
            'receta_id' => $id,
        ]);

        return response()->json(['message' => 'Receta guardada']);
    }

    /**
     * 📋 Obtener favoritas del usuario
     */
    public function favoritas(Request $request)
    {
        $usuario = $request->user();

        $favoritas = $usuario->recetasGuardadas()
            ->with('receta.ingredientes')
            ->get()
            ->pluck('receta');

        return response()->json($favoritas);
    }
}
