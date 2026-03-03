<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$receta = new \App\Models\Receta();
$receta->titulo = 'Pasta Carbonara';
$receta->descripcion = 'Clásica receta italiana con huevo, queso pecorino y guanciale';
$receta->tiempo_preparacion = 25;
$receta->calorias_porcion = 450;
$receta->dificultad = 'Media';
$receta->ingredientes = [
    ['nombre' => 'Spaghetti', 'cantidad' => 200, 'unidad' => 'g'],
    ['nombre' => 'Huevos', 'cantidad' => 2, 'unidad' => 'unidades'],
    ['nombre' => 'Queso pecorino', 'cantidad' => 50, 'unidad' => 'g'],
    ['nombre' => 'Guanciale', 'cantidad' => 100, 'unidad' => 'g'],
    ['nombre' => 'Pimienta negra', 'cantidad' => 1, 'unidad' => 'cucharadita']
];
$receta->pasos = [
    'Cortar el guanciale en cubos pequeños',
    'Hervir agua con sal y cocinar la pasta durante 10 minutos',
    'Freír el guanciale en una sartén a fuego medio durante 5 minutos hasta que esté crujiente',
    'Batir los huevos con el queso pecorino rallado y pimienta negra',
    'Mezclar la pasta escurrida (reservar un poco de agua) con el guanciale caliente',
    'Agregar la mezcla de huevos y revolver rápidamente fuera del fuego',
    'Servir inmediatamente con más queso pecorino y pimienta negra al gusto'
];
$receta->save();

echo "✅ Receta creada exitosamente!\n";
echo "ID: " . $receta->_id . "\n";
echo "Título: " . $receta->titulo . "\n";
echo "Pasos: " . count($receta->pasos) . "\n";
