<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RecetasController;
use App\Http\Controllers\RecetasGuardadasController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\AdminController; // ✅ Importación correcta
use App\Http\Controllers\AlexaController;
use App\Http\Controllers\AlexaTimerController;

// 🔓 Rutas públicas
Route::get('/health', function () {
    try {
        // Test MongoDB connection
        $connection = DB::connection('mongodb');
        $connection->getDatabaseName();
        
        // Count users
        $userCount = \App\Models\Usuario::count();
        
        // Test JWT
        $jwtConfigured = config('jwt.secret') ? 'yes' : 'no';
        
        return response()->json([
            'status' => 'ok',
            'database' => 'connected',
            'db_name' => config('database.connections.mongodb.database'),
            'users_count' => $userCount,
            'env' => [
                'APP_ENV' => config('app.env'),
                'APP_DEBUG' => config('app.debug'),
                'DB_CONNECTION' => config('database.default'),
                'JWT_CONFIGURED' => $jwtConfigured,
                'JWT_TTL' => config('jwt.ttl')
            ]
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ], 500);
    }
});

Route::get('/test-login-setup', function () {
    try {
        $results = [];
        
        // 1. Check database connection
        try {
            DB::connection('mongodb')->getDatabaseName();
            $results['database'] = '✓ Connected';
        } catch (\Exception $e) {
            $results['database'] = '✗ Error: ' . $e->getMessage();
        }
        
        // 2. Check users collection
        try {
            $userCount = \App\Models\Usuario::count();
            $results['users'] = "✓ Found $userCount users";
            
            if ($userCount > 0) {
                $firstUser = \App\Models\Usuario::first();
                $results['first_user'] = [
                    'email' => $firstUser->email,
                    'has_password' => !empty($firstUser->password),
                    'password_length' => strlen($firstUser->password ?? '')
                ];
            }
        } catch (\Exception $e) {
            $results['users'] = '✗ Error: ' . $e->getMessage();
        }
        
        // 3. Check JWT config
        $results['jwt_secret'] = config('jwt.secret') ? '✓ Configured' : '✗ Missing';
        $results['jwt_ttl'] = config('jwt.ttl');
        
        // 4. Check app key
        $results['app_key'] = config('app.key') ? '✓ Configured' : '✗ Missing';
        
        return response()->json($results);
    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ], 500);
    }
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// 🎙️ Rutas para Alexa (públicas para que Lambda pueda acceder)
Route::prefix('alexa')->group(function () {
    Route::get('/recetas', [AlexaController::class, 'obtenerRecetas']);
    Route::get('/receta/detalle', [AlexaController::class, 'obtenerDetalleReceta']);
    Route::get('/receta/paso', [AlexaController::class, 'obtenerPaso']);
    Route::get('/recetas/buscar', [AlexaController::class, 'buscarPorIngrediente']);
    Route::get('/recetas/tipo', [AlexaController::class, 'obtenerPorTipo']);
    Route::post('/timer/control', [AlexaTimerController::class, 'controlTimer']);
});

// 🔐 Rutas protegidas con JWT
Route::middleware('auth:api')->group(function () {
    // Auth
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', fn(Request $request) => $request->user());
    Route::get('/yo', [UsuarioController::class, 'yo']); // ✅ Corregido

    // 🏠 Home
    Route::get('/home', [RecetasController::class, 'home']);

    // 🍽️ Recetas
    Route::prefix('recetas')->group(function () {
        Route::post('/', [RecetasController::class, 'store']);
        Route::get('/', [RecetasController::class, 'index']);
        Route::get('/seguras', [RecetasController::class, 'filtradasPorAlergia']);
        Route::get('/mis-recetas', [RecetasController::class, 'misRecetas']);
        Route::post('/recomendadas', [RecetasController::class, 'recomendadas']);
        Route::get('/buscar', [RecetasController::class, 'buscarPorIngredientes']);
        Route::get('/populares', [RecetasController::class, 'populares']);
        Route::get('/sugeridas', [RecetasController::class, 'sugeridas']);
        Route::get('/favoritas', [RecetasGuardadasController::class, 'favoritas']); // ⭐ Listado de favoritas
        Route::get('/{id}', [RecetasController::class, 'show']); // 📖 Ver detalle de receta
        Route::put('/{id}', [RecetasController::class, 'update']);
        Route::delete('/{id}', [RecetasController::class, 'destroy']);

        // ⭐ Favoritos
        Route::post('/{id}/guardar', [RecetasGuardadasController::class, 'guardar']);
    });

    // 👤 Perfil del usuario
    Route::put('/usuarios/perfil', [UsuarioController::class, 'actualizarPerfil']);

    // 👑 Rutas de administrador
    Route::middleware('is_admin')->prefix('admin')->group(function () {
        // Users
        Route::get('/users', [AdminController::class, 'getUsers']);
        Route::post('/users', [UsuarioController::class, 'store']);
        Route::put('/users/{id}', [UsuarioController::class, 'update']);
        Route::delete('/users/{id}', [UsuarioController::class, 'destroy']);
        
        // Recipes
        Route::get('/recipes', [AdminController::class, 'getRecipes']);
        Route::delete('/recipes/{id}', [RecetasController::class, 'destroy']);
        
        // Backup routes
        Route::get('/backup/collections', [AdminController::class, 'getCollections']);
        Route::post('/backup/create', [AdminController::class, 'createBackup']);
    });
});
