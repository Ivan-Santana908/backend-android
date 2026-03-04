<?php

require __DIR__ . '/vendor/autoload.php';

use MongoDB\Client;

try {
    // Conectar a MongoDB Atlas
    $connectionString = "mongodb+srv://alejandro908:polo90812@cluster0.hi5jkhs.mongodb.net/culinarysmart?retryWrites=true&w=majority";
    $client = new Client($connectionString);
    
    $database = $client->culinarysmart;
    $collection = $database->usuarios;
    
    // Verificar si ya existe el usuario
    $existingUser = $collection->findOne(['email' => 'test@culinarysmart.com']);
    
    if ($existingUser) {
        echo "✓ Usuario de prueba ya existe\n";
        echo "Email: test@culinarysmart.com\n";
        echo "Password: test123\n";
    } else {
        // Hash de la contraseña (bcrypt manualmente)
        $password = password_hash('test123', PASSWORD_BCRYPT);
        
        // Crear usuario
        $result = $collection->insertOne([
            'nombre' => 'Usuario de Prueba',
            'email' => 'test@culinarysmart.com',
            'password' => $password,
            'personas' => 1,
            'rol' => 'user',
            'perfilCompleto' => false,
            'recetas_guardadas' => [],
            'alergias' => [],
            'preferencias' => ['Vegetariana', 'Sin gluten'],
            'metaCalorias' => 14000,
            'planes_semanales' => [],
            'listas_de_compra' => [],
            'created_at' => new MongoDB\BSON\UTCDateTime(),
            'updated_at' => new MongoDB\BSON\UTCDateTime()
        ]);
        
        echo "✓ Usuario de prueba creado exitosamente\n";
        echo "Email: test@culinarysmart.com\n";
        echo "Password: test123\n";
        echo "ID: " . $result->getInsertedId() . "\n";
    }
    
    // Contar usuarios totales
    $count = $collection->countDocuments();
    echo "\nTotal de usuarios en la base de datos: $count\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
