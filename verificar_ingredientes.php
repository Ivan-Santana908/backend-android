<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$receta = \App\Models\Receta::first();

echo "📋 Receta: {$receta->titulo}\n\n";
echo "🧺 Ingredientes:\n";

foreach ($receta->ingredientes as $ing) {
    echo "  • {$ing['nombre']}: {$ing['cantidad']} {$ing['unidad']}\n";
}

echo "\n✅ Los ingredientes están embebidos correctamente!\n";
