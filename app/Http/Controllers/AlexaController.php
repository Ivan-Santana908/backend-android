<?php

namespace App\Http\Controllers;

use App\Models\Receta;
use Illuminate\Http\Request;

class AlexaController extends Controller
{
    /**
     * Obtener todas las recetas para Alexa
     */
    public function obtenerRecetas()
    {
        try {
            $recetas = Receta::all(['titulo', 'tipo', 'ingredientes', 'pasos', 'dificultad']);
            
            return response()->json([
                'success' => true,
                'data' => $recetas->map(function($receta) {
                    return [
                        'id' => $receta->_id,
                        'titulo' => $receta->titulo,
                        'tipo' => $receta->tipo,
                        'ingredientes' => collect($receta->ingredientes)->pluck('nombre')->toArray(),
                        'pasos' => $receta->pasos ?? [],
                        'dificultad' => $receta->dificultad
                    ];
                })
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener recetas: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener detalle de una receta por ID o título
     */
    public function obtenerDetalleReceta(Request $request)
    {
        try {
            $titulo = $request->input('titulo');
            $id = $request->input('id');
            
            if ($id) {
                $receta = Receta::find($id);
            } else {
                $receta = Receta::where('titulo', 'like', '%' . $titulo . '%')->first();
            }
            
            if (!$receta) {
                return response()->json([
                    'success' => false,
                    'message' => 'Receta no encontrada'
                ], 404);
            }
            
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $receta->_id,
                    'titulo' => $receta->titulo,
                    'descripcion' => $receta->descripcion,
                    'ingredientes' => $receta->ingredientes,
                    'pasos' => $receta->pasos ?? [],
                    'tiempo_preparacion' => $receta->tiempo_preparacion,
                    'tiempo_coccion' => $receta->tiempo_coccion,
                    'dificultad' => $receta->dificultad,
                    'porciones' => $receta->porciones
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener receta: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener un paso específico de una receta
     */
    public function obtenerPaso(Request $request)
    {
        try {
            $recetaId = $request->input('receta_id');
            $numeroPaso = (int) $request->input('numero_paso', 0);
            
            $receta = Receta::find($recetaId);
            
            if (!$receta) {
                return response()->json([
                    'success' => false,
                    'message' => 'Receta no encontrada'
                ], 404);
            }
            
            $pasos = $receta->pasos ?? [];
            
            if ($numeroPaso < 0 || $numeroPaso >= count($pasos)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Número de paso inválido'
                ], 400);
            }
            
            return response()->json([
                'success' => true,
                'data' => [
                    'titulo' => $receta->titulo,
                    'numero_paso' => $numeroPaso,
                    'total_pasos' => count($pasos),
                    'paso' => $pasos[$numeroPaso],
                    'es_ultimo' => $numeroPaso === (count($pasos) - 1)
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener paso: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Buscar recetas por ingrediente
     */
    public function buscarPorIngrediente(Request $request)
    {
        try {
            $ingrediente = $request->input('ingrediente');
            
            $recetas = Receta::where('ingredientes.nombre', 'like', '%' . $ingrediente . '%')->get();
            
            return response()->json([
                'success' => true,
                'data' => $recetas->map(function($receta) {
                    return [
                        'id' => $receta->_id,
                        'titulo' => $receta->titulo,
                        'tipo' => $receta->tipo,
                        'dificultad' => $receta->dificultad
                    ];
                })
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al buscar recetas: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener recetas por tipo
     */
    public function obtenerPorTipo(Request $request)
    {
        try {
            $tipo = $request->input('tipo');
            
            $recetas = Receta::where('tipo', $tipo)->get(['titulo', 'tipo', 'dificultad', 'tiempo_preparacion']);
            
            return response()->json([
                'success' => true,
                'data' => $recetas
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener recetas: ' . $e->getMessage()
            ], 500);
        }
    }
}
