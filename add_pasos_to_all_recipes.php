<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Pasos genéricos por tipo de receta
$pasosTemplates = [
    'default' => [
        'Lava todos los ingredientes frescos bajo agua fría. Seca con papel absorbente. Coloca todos los ingredientes organizados en tu mesa de trabajo.',
        'Corta cada ingrediente con un cuchillo afilado: verduras en cubos de 2cm, proteínas en trozos uniformes de 3cm. Separa en bowls diferentes.',
        'Precalienta un sartén grande a fuego medio durante 2 minutos. Agrega 2 cucharadas de aceite y espera a que brille.',
        'Cocina los ingredientes principales sin mover durante 3-4 minutos. Voltea y cocina 3-4 minutos más hasta dorar. Temperatura interna: 75°C.',
        'Reduce el fuego a bajo. Agrega sal (1 cucharadita), pimienta (½ cucharadita) y tus especias favoritas. Mezcla con cuchara de madera.',
        'Con movimientos envolventes, mezcla de abajo hacia arriba durante 1 minuto hasta integrar todos los sabores.',
        'Apaga el fuego. Sirve en platos calientes. Decora con hierbas frescas picadas. Sirve inmediatamente mientras está caliente.'
    ],
    'tacos' => [
        'Corta 500g de pollo en cubos de 2cm. Colócalos en un bowl. Añade 1 cucharadita de sal, ½ cucharadita de pimienta, 1 cucharadita de comino y ½ cucharadita de pimentón. Mezcla bien con las manos durante 30 segundos.',
        'Calienta un sartén grande con 3 cucharadas de aceite vegetal a fuego medio-alto durante 2 minutos. El aceite debe estar brillante pero sin humear.',
        'Agrega el pollo al sartén en una sola capa (no amontones). Cocina sin mover durante 4 minutos hasta que se dore. Voltea cada pieza y cocina 4-5 minutos más. El pollo debe estar dorado y con temperatura interna de 75°C.',
        'Mientras el pollo cocina, calienta 8-10 tortillas: colócalas directamente sobre la llama del fogón (o en un comal seco) durante 15-20 segundos por lado. Guárdalas en un trapo limpio para mantenerlas calientes.',
        'Lava y seca las verduras. Corta 1 taza de lechuga en tiras finas. Pica 2 tomates en cubos pequeños de 0.5cm. Corta 1 cebolla en cubitos muy finos. Separa cada ingrediente en bowls pequeños.',
        'Toma una tortilla caliente, coloca 3-4 piezas de pollo en el centro. No sobrecargues o se romperá la tortilla.',
        'Agrega al gusto: lechuga, tomate, cebolla. Añade 1 cucharada de salsa, unas gotas de limón y cilantro fresco. Dobla y come inmediatamente mientras está caliente.'
    ],
    'ensalada' => [
        'Lavar bien todas las verduras bajo agua fría',
        'Cortar la lechuga en trozos medianos',
        'Picar los tomates en cubos pequeños',
        'Cortar el aguacate en rebanadas',
        'Mezclar todos los ingredientes en un bowl grande',
        'Preparar el aderezo con aceite, vinagre y sal',
        'Servir fresco y añadir el aderezo justo antes de comer'
    ],
    'pasta' => [
        'Llena una olla grande (4-5 litros) con agua hasta ¾ de su capacidad. Agrega 2 cucharadas de sal gruesa. Enciende el fuego alto. Pon la tapa para que hierva más rápido (tomará 8-10 minutos).',
        'Cuando el agua hierva a borbotones, retira la tapa. Agrega 400g de pasta. Revuelve inmediatamente con cuchara de madera para evitar que se pegue. Cocina según el tiempo del paquete (generalmente 8-12 minutos). Revuelve cada 2-3 minutos. Prueba 1 minuto antes del tiempo indicado.',
        'Mientras la pasta cocina, calienta un sartén grande a fuego medio. Agrega 3 cucharadas de aceite de oliva o 30g de mantequilla. Espera 30 segundos a que se caliente.',
        'En el sartén caliente, añade ajo picado (3 dientes) y sofríe durante 30 segundos hasta que huela bien (cuidado, no debe quemarse). Agrega tu salsa o ingredientes principales. Cocina removiendo constantemente durante 4-5 minutos a fuego medio.',
        'Cuando la pasta esté al dente (firme al morderla, no dura), reserva 1 taza del agua de cocción en un vaso. Escurre la pasta en un colador. NO LA ENJUAGUES. Sacude el colador para eliminar el exceso de agua.',
        'Agrega inmediatamente la pasta escurrida al sartén con la salsa. Mezcla con pinzas o dos cucharas durante 1-2 minutos a fuego medio. Si se ve seca, agrega el agua de cocción reservada poco a poco (2-3 cucharadas).',
        'Apaga el fuego. Sirve en platos calientes. Espolvorea 2 cucharadas de queso parmesano rallado sobre cada plato. Decora con albahaca fresca o perejil picado. Come inmediatamente.'
    ],
    'arroz' => [
        'Lavar el arroz bajo agua fría hasta que el agua salga clara',
        'Calentar aceite en una olla y sofreír el arroz 2 minutos',
        'Agregar el agua o caldo (proporción 1:2)',
        'Añadir sal y llevar a ebullición',
        'Reducir el fuego, tapar y cocinar durante 15 minutos',
        'Apagar el fuego y dejar reposar tapado por 5 minutos',
        'Esponjar con un tenedor y servir caliente'
    ],
    'sopa' => [
        'Picar todas las verduras en trozos medianos',
        'Calentar aceite en una olla grande a fuego medio',
        'Sofreír la cebolla y el ajo hasta que estén transparentes',
        'Agregar el resto de las verduras y cocinar 5 minutos',
        'Añadir el caldo o agua y llevar a ebullición',
        'Reducir el fuego y cocinar a fuego lento durante 20 minutos',
        'Ajustar la sazón y servir caliente con pan'
    ],
    'pollo' => [
        'Limpiar y secar el pollo con papel absorbente',
        'Sazonar el pollo con sal, pimienta y especias al gusto',
        'Calentar aceite en un sartén grande a fuego medio-alto',
        'Cocinar el pollo por ambos lados durante 6-8 minutos por lado',
        'Verificar que esté bien cocido (temperatura interna de 75°C)',
        'Dejar reposar el pollo 5 minutos antes de cortar',
        'Servir con guarnición de tu elección'
    ],
    'carne' => [
        'Sacar la carne del refrigerador 30 minutos antes de cocinar',
        'Secar la carne con papel absorbente y sazonar generosamente',
        'Calentar bien el sartén hasta que esté muy caliente',
        'Cocinar la carne 4-5 minutos por lado según el término deseado',
        'No mover la carne mientras se forma la costra dorada',
        'Retirar del fuego y dejar reposar 5-10 minutos',
        'Cortar en contra de la fibra y servir'
    ],
    'pescado' => [
        'Lavar el pescado y secarlo bien con papel absorbente',
        'Sazonar con sal, pimienta y jugo de limón',
        'Calentar aceite o mantequilla en un sartén a fuego medio',
        'Cocinar el pescado con la piel hacia abajo durante 4 minutos',
        'Voltear cuidadosamente y cocinar 3 minutos más',
        'El pescado está listo cuando se deshace fácilmente',
        'Servir inmediatamente con limón y perejil fresco'
    ]
];

// Obtener todas las recetas
$recetas = \App\Models\Receta::all();
$actualizadas = 0;

echo "🔍 Encontradas " . $recetas->count() . " recetas\n";
echo "📝 Agregando pasos a las recetas...\n\n";

foreach ($recetas as $receta) {
    // Si ya tiene pasos, omitir
    if (!empty($receta->pasos) && is_array($receta->pasos) && count($receta->pasos) > 0) {
        echo "⏭️  Omitiendo '{$receta->titulo}' - Ya tiene pasos\n";
        continue;
    }

    // Determinar qué template usar basado en el título
    $titulo = strtolower($receta->titulo);
    $pasos = $pasosTemplates['default'];

    if (str_contains($titulo, 'taco')) {
        $pasos = $pasosTemplates['tacos'];
    } elseif (str_contains($titulo, 'ensalada')) {
        $pasos = $pasosTemplates['ensalada'];
    } elseif (str_contains($titulo, 'pasta') || str_contains($titulo, 'spaguetti') || str_contains($titulo, 'carbonara')) {
        $pasos = $pasosTemplates['pasta'];
    } elseif (str_contains($titulo, 'arroz')) {
        $pasos = $pasosTemplates['arroz'];
    } elseif (str_contains($titulo, 'sopa') || str_contains($titulo, 'caldo')) {
        $pasos = $pasosTemplates['sopa'];
    } elseif (str_contains($titulo, 'pollo')) {
        $pasos = $pasosTemplates['pollo'];
    } elseif (str_contains($titulo, 'carne') || str_contains($titulo, 'res') || str_contains($titulo, 'bistec')) {
        $pasos = $pasosTemplates['carne'];
    } elseif (str_contains($titulo, 'pescado') || str_contains($titulo, 'salmón') || str_contains($titulo, 'atún')) {
        $pasos = $pasosTemplates['pescado'];
    }

    // Actualizar la receta
    $receta->pasos = $pasos;
    $receta->save();
    
    $actualizadas++;
    echo "✅ Actualizada: '{$receta->titulo}' con " . count($pasos) . " pasos\n";
}

echo "\n🎉 Proceso completado!\n";
echo "📊 Total de recetas actualizadas: $actualizadas\n";
