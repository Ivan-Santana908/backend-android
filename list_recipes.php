<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$recetas = \App\Models\Receta::all();

echo "📋 Lista de recetas en la base de datos:\n\n";

foreach ($recetas as $receta) {
    echo "ID: " . $receta->_id . "\n";
    echo "Título: " . $receta->titulo . "\n";
    echo "Pasos: " . (is_array($receta->pasos) ? count($receta->pasos) : 0) . "\n";
    echo "---\n\n";
}
