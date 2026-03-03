<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use MongoDB\Client;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Storage;

class BackupController extends Controller
{
    public function getCollections()
    {
        try {
            $client = new Client(config('database.connections.mongodb.dsn'));
            $database = $client->selectDatabase(config('database.connections.mongodb.database'));
            $collections = iterator_to_array($database->listCollections());
            
            $collectionNames = array_map(function($collection) {
                return $collection->getName();
            }, $collections);

            return response()->json([
                'success' => true,
                'collections' => $collectionNames
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener las colecciones: ' . $e->getMessage()
            ], 500);
        }
    }

    public function createBackup(Request $request)
    {
        $request->validate([
            'collections' => 'required|array',
            'path' => 'required|string'
        ]);

        try {
            $dbName = config('database.connections.mongodb.database');
            $host = config('database.connections.mongodb.host');
            $port = config('database.connections.mongodb.port');
            
            $collections = implode(' ', array_map(function($collection) {
                return "--collection=$collection";
            }, $request->collections));

            $outputPath = $request->path . '/' . date('Y-m-d_H-i-s') . '_backup';
            
            // Crear el directorio si no existe
            if (!file_exists($request->path)) {
                mkdir($request->path, 0777, true);
            }

            $command = "mongodump --host=$host --port=$port --db=$dbName $collections --out=$outputPath";
            
            $process = Process::fromShellCommandline($command);
            $process->run();

            if (!$process->isSuccessful()) {
                throw new \RuntimeException($process->getErrorOutput());
            }

            return response()->json([
                'success' => true,
                'message' => 'Respaldo creado exitosamente en: ' . $outputPath,
                'path' => $outputPath
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el respaldo: ' . $e->getMessage()
            ], 500);
        }
    }
}
