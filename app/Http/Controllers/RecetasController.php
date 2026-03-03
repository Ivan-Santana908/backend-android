<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Receta;

class RecetasController extends Controller
{
    /**
     * 🔍 Listar todas las recetas con sus ingredientes
     */
    public function index()
    {
        $recetas = Receta::with('ingredientes')->get();
        return response()->json($recetas);
    }

    /**
     * 🚫 Listar recetas seguras según alergias del usuario
     */
    public function filtradasPorAlergia(Request $request)
    {
        $usuario = $request->user();

        $recetasSeguras = Receta::segurasPara($usuario)
            ->with('ingredientes')
            ->get();

        return response()->json($recetasSeguras);
    }

    /**
     * 🔎 Buscar recetas que contengan al menos uno de los ingredientes proporcionados
     */
    public function buscarPorIngredientes(Request $request)
    {
        $ingredientesBuscados = $request->input('ingredientes'); // array de nombres

        if (empty($ingredientesBuscados)) {
            return response()->json(['error' => 'No se especificaron ingredientes'], 400);
        }

        $buscados = collect($ingredientesBuscados)->map(fn($i) => strtolower($i))->toArray();

        $recetas = Receta::with('ingredientes')
            ->get()
            ->filter(function ($receta) use ($buscados) {
                $nombres = $receta->ingredientes->pluck('nombre')->map(fn($i) => strtolower($i))->toArray();
                return count(array_intersect($buscados, $nombres)) >= 1;
            })
            ->values();

        return response()->json($recetas);
    }

    /**
     * ➕ Crear nueva receta
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'calorias' => 'nullable|integer|min:0',
            'ingredientes' => 'required|array',
            'ingredientes.*.id' => 'required|integer|exists:ingredientes,id',
            'ingredientes.*.cantidad' => 'required|integer|min:1',
            'ingredientes.*.unidad' => 'nullable|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $usuario = $request->user();

        DB::beginTransaction();

        try {
            $receta = Receta::create([
                'titulo' => $request->titulo,
                'descripcion' => $request->descripcion,
                'calorias' => $request->calorias,
                'usuario_id' => $usuario->id,
            ]);

            foreach ($request->ingredientes as $item) {
                $receta->ingredientes()->attach($item['id'], [
                    'cantidad' => $item['cantidad'],
                    'unidad' => $item['unidad'] ?? null,
                ]);
            }

            DB::commit();

            return response()->json([
                'message' => 'Receta creada exitosamente',
                'receta' => $receta->load('ingredientes')
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error al crear la receta'], 500);
        }
    }

    /**
     * 📖 Ver detalle de una receta específica
     */
    public function show($id)
    {
        try {
            $receta = Receta::with('ingredientes')->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => $receta
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Receta no encontrada'
            ], 404);
        }
    }

    /**
     * ✏️ Actualizar receta existente
     */
    public function update($id, Request $request)
    {
        $usuario = $request->user();
        $receta = Receta::findOrFail($id);

        if ($receta->usuario_id !== $usuario->id) {
            return response()->json(['error' => 'No tienes permiso para modificar esta receta'], 403);
        }

        $validator = Validator::make($request->all(), [
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'calorias' => 'nullable|integer|min:0',
            'ingredientes' => 'required|array',
            'ingredientes.*.id' => 'required|integer|exists:ingredientes,id',
            'ingredientes.*.cantidad' => 'required|integer|min:1',
            'ingredientes.*.unidad' => 'nullable|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        DB::beginTransaction();

        try {
            $receta->update([
                'titulo' => $request->titulo,
                'descripcion' => $request->descripcion,
                'calorias' => $request->calorias,
            ]);

            $syncData = collect($request->ingredientes)->mapWithKeys(function ($item) {
                return [$item['id'] => [
                    'cantidad' => $item['cantidad'],
                    'unidad' => $item['unidad'] ?? null,
                ]];
            })->toArray();

            $receta->ingredientes()->sync($syncData);

            DB::commit();

            return response()->json([
                'message' => 'Receta actualizada',
                'receta' => $receta->load('ingredientes')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error al actualizar la receta'], 500);
        }
    }
    /**
     * 🗑️ Eliminar receta
     */
    public function destroy($id, Request $request)
    {
        $usuario = $request->user();
        $receta = Receta::findOrFail($id);

        if ($receta->usuario_id !== $usuario->id) {
            return response()->json(['error' => 'No tienes permiso para eliminar esta receta'], 403);
        }

        DB::transaction(function () use ($receta) {
            $receta->ingredientes()->detach();
            $receta->delete();
        });

        return response()->json(['message' => 'Receta eliminada']);
    }

    /**
     * 👤 Listar recetas del usuario autenticado
     */
    public function misRecetas(Request $request)
    {
        $usuario = $request->user();

        $recetas = Receta::with('ingredientes')
            ->where('usuario_id', $usuario->id)
            ->get();

        return response()->json($recetas);
    }

    /**
     * 🧠 Recomendaciones según ingredientes disponibles y alergias
     */
    public function recomendadas(Request $request)
    {
        $usuario = $request->user();
        $ingredientesDisponibles = $request->input('ingredientes'); // array de nombres

        if (empty($ingredientesDisponibles)) {
            return response()->json(['error' => 'Debes proporcionar al menos un ingrediente disponible'], 400);
        }

        $disponibles = collect($ingredientesDisponibles)->map(fn($i) => strtolower($i))->toArray();

        $recetas = Receta::segurasPara($usuario)
            ->with('ingredientes')
            ->get()
            ->filter(function ($receta) use ($disponibles) {
                $nombres = $receta->ingredientes->pluck('nombre')->map(fn($i) => strtolower($i))->toArray();
                return count(array_intersect($nombres, $disponibles)) >= 1;
            })
            ->values();

        return response()->json($recetas);
    }

    /**
     * 🔥 Recetas más populares (más guardadas)
     */
    public function populares()
    {
        $recetas = Receta::with('ingredientes')
            ->leftJoin('recetas_guardadas', 'recetas.id', '=', 'recetas_guardadas.receta_id')
            ->select('recetas.*', DB::raw('COUNT(recetas_guardadas.id) as total_guardadas'))
            ->groupBy('recetas.id')
            ->orderByDesc('total_guardadas')
            ->take(10)
            ->get()
            ->map(function ($receta) {
                return [
                    'id' => $receta->id,
                    'titulo' => $receta->titulo,
                    'descripcion' => $receta->descripcion,
                    'calorias' => $receta->calorias,
                    'ingredientes' => $receta->ingredientes,
                    'popular' => true,
                    'motivo' => 'Más guardada por la comunidad',
                ];
            });

        return response()->json($recetas);
    }

    /**
     * 🪄 Sugerencias personalizadas
     */
    public function sugeridas(Request $request)
    {
        $usuario = $request->user();
        $recetasGuardadasIds = $usuario->recetasGuardadas()->pluck('receta_id')->toArray();

        $recetas = Receta::segurasPara($usuario)
            ->with('ingredientes')
            ->whereNotIn('id', $recetasGuardadasIds)
            ->inRandomOrder()
            ->take(5)
            ->get()
            ->map(function ($receta) {
                return [
                    'id' => $receta->id,
                    'titulo' => $receta->titulo,
                    'descripcion' => $receta->descripcion,
                    'calorias' => $receta->calorias,
                    'ingredientes' => $receta->ingredientes,
                    'sugerida' => true,
                    'motivo' => 'Basado en tus ingredientes y alergias',
                ];
            });

        return response()->json($recetas);
    }

    /**
     * 🏠 Vista principal con secciones personalizadas
     */
    public function home(Request $request)
    {
        $usuario = $request->user();
        $recetasGuardadasIds = $usuario->recetasGuardadas()->pluck('receta_id')->toArray();

        // 🔥 Populares
        $populares = Receta::with('ingredientes')
            ->leftJoin('recetas_guardadas', 'recetas.id', '=', 'recetas_guardadas.receta_id')
            ->select('recetas.*', DB::raw('COUNT(recetas_guardadas.id) as total_guardadas'))
            ->groupBy('recetas.id')
            ->orderByDesc('total_guardadas')
            ->take(5)
            ->get()
            ->map(fn($receta) => [
                ...$receta->toArray(),
                'motivo' => 'Más guardada por la comunidad',
                'tipo' => 'popular'
            ]);

        // 🪄 Sugeridas
        $sugeridas = Receta::segurasPara($usuario)
            ->with('ingredientes')
            ->whereNotIn('id', $recetasGuardadasIds)
            ->inRandomOrder()
            ->take(5)
            ->get()
            ->map(fn($receta) => [
                ...$receta->toArray(),
                'motivo' => 'Basada en tus alergias y lo que no has guardado',
                'tipo' => 'sugerida'
            ]);

        // 🧠 Recetas seguras
        $seguras = Receta::segurasPara($usuario)
            ->with('ingredientes')
            ->take(5)
            ->get()
            ->map(fn($receta) => [
                ...$receta->toArray(),
                'motivo' => 'Receta apta según tus alergias',
                'tipo' => 'segura'
            ]);

        // 👤 Mis recetas
        $mias = Receta::with('ingredientes')
            ->where('usuario_id', $usuario->id)
            ->latest()
            ->take(5)
            ->get()
            ->map(fn($receta) => [
                ...$receta->toArray(),
                'motivo' => 'Receta creada por ti',
                'tipo' => 'personal'
            ]);

        return response()->json([
            'populares' => $populares,
            'sugeridas' => $sugeridas,
            'seguras'   => $seguras,
            'mias'      => $mias,
        ]);
    }
}
