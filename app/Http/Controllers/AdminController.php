<?php

namespace App\Http\Controllers;

use App\Models\Receta;
use App\Models\Usuario;
use App\Models\Ingrediente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use MongoDB\Client;

class AdminController extends Controller
{
    public function getUsers()
    {
        try {
            $users = Usuario::all()->toArray();
            return response()->json(['users' => $users]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener usuarios', 'message' => $e->getMessage()], 500);
        }
    }

    public function getRecipes()
    {
        try {
            $recipes = Receta::all();
            $recipesArray = [];
            
            foreach ($recipes as $recipe) {
                $recipesArray[] = [
                    '_id' => $recipe->_id,
                    'titulo' => $recipe->titulo,
                    'descripcion' => $recipe->descripcion,
                    'calorias_porcion' => (int) $recipe->calorias_porcion,
                    'imagen' => $recipe->imagen,
                    'tiempo_preparacion' => (int) $recipe->tiempo_preparacion,
                    'tiempo_coccion' => (int) $recipe->tiempo_coccion,
                    'porciones' => (int) $recipe->porciones,
                    'dificultad' => $recipe->dificultad,
                    'tipo' => $recipe->tipo,
                    'ingredientes' => $recipe->ingredientes ? $recipe->ingredientes : [],
                    'pasos' => $recipe->pasos ? $recipe->pasos : [],
                    'autor' => $recipe->autor ? $recipe->autor : []
                ];
            }
            
            return response()->json(['recipes' => $recipesArray]);
        } catch (\Exception $e) {
            \Log::error('Error en getRecipes: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            return response()->json([
                'error' => 'Error al obtener recetas',
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }
    public function getCollections()
    {
        try {
            $client = new Client(env('MONGODB_URI'));
            $database = $client->selectDatabase(env('DB_DATABASE'));
            $collections = [];
            
            foreach ($database->listCollections() as $collection) {
                $collections[] = $collection->getName();
            }
            
            return response()->json(['collections' => $collections]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener colecciones', 'message' => $e->getMessage()], 500);
        }
    }

    public function createBackup(Request $request)
    {
        try {
            $validated = $request->validate([
                'collections' => 'required|array',
                'collections.*' => 'string'
            ]);

            $timestamp = now()->format('Y-m-d_H-i-s');
            $filename = "backup_{$timestamp}.json";

            // Conectar a MongoDB y obtener los datos
            $client = new Client(env('MONGODB_URI'));
            $database = $client->selectDatabase(env('DB_DATABASE'));
            $backupData = [];

            foreach ($validated['collections'] as $collectionName) {
                try {
                    $collection = $database->selectCollection($collectionName);
                    $documents = iterator_to_array($collection->find([], ['typeMap' => ['root' => 'array']]));
                    
                    // Convertir ObjectIds a strings para JSON
                    array_walk_recursive($documents, function(&$value) {
                        if ($value instanceof \MongoDB\BSON\ObjectId) {
                            $value = (string) $value;
                        }
                    });
                    
                    $backupData[$collectionName] = $documents;
                } catch (\Exception $e) {
                    \Log::error("Error al respaldar colección {$collectionName}: " . $e->getMessage());
                    continue;
                }
            }

            if (empty($backupData)) {
                throw new \Exception('No se pudo obtener datos de ninguna colección');
            }

            $jsonContent = json_encode($backupData, JSON_PRETTY_PRINT);

            return response($jsonContent)
                ->header('Content-Type', 'application/json')
                ->header('Content-Disposition', 'attachment; filename=' . $filename);

        } catch (\Exception $e) {
            \Log::error('Error en createBackup: ' . $e->getMessage());
            return response()->json([
                'error' => 'Error al crear respaldo',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
