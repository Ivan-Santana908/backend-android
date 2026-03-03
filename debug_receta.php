<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$receta = \App\Models\Receta::first();

echo "Raw data:\n";
print_r($receta->toArray());
