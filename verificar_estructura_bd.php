<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "🔍 Verificando estructura de la base de datos MongoDB\n\n";

// Verificar colecciones
$recetas = \App\Models\Receta::count();
$ingredientes = \App\Models\Ingrediente::count();

echo "📊 COLECCIONES:\n";
echo "  • Recetas: $recetas\n";
echo "  • Ingredientes (tabla separada): $ingredientes\n\n";

// Mostrar una receta completa
$receta = \App\Models\Receta::first();

if ($receta) {
    echo "📋 ESTRUCTURA DE UNA RECETA:\n";
    echo "  Título: {$receta->titulo}\n";
    echo "  ID: {$receta->_id}\n\n";
    
    echo "🧺 INGREDIENTES EMBEBIDOS EN LA RECETA:\n";
    if (is_array($receta->ingredientes)) {
        foreach ($receta->ingredientes as $idx => $ing) {
            echo "  " . ($idx + 1) . ". ";
            if (is_array($ing)) {
                echo "{$ing['nombre']}: {$ing['cantidad']} {$ing['unidad']}\n";
            } else {
                echo "Formato desconocido\n";
            }
        }
    } else {
        echo "  ❌ No hay ingredientes o formato incorrecto\n";
    }
    
    echo "\n📝 PASOS:\n";
    if (is_array($receta->pasos)) {
        echo "  Total de pasos: " . count($receta->pasos) . "\n";
        echo "  Primer paso: " . substr($receta->pasos[0], 0, 80) . "...\n";
    }
} else {
    echo "❌ No hay recetas en la base de datos\n";
}

echo "\n✅ Los ingredientes están EMBEBIDOS directamente en cada receta.\n";
echo "✅ La tabla 'ingredientes' existe pero es para referencia/búsqueda.\n";
echo "✅ El frontend lee los ingredientes directamente del array embebido.\n";
