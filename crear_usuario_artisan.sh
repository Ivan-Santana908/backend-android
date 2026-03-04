#!/bin/bash
# Script para crear usuario de prueba en Railway

# Ejecutar en Railway Shell:
php artisan tinker --execute="
\$usuario = new App\Models\Usuario();
\$usuario->nombre = 'Test User';
\$usuario->email = 'test@test.com';
\$usuario->password = Hash::make('123456');
\$usuario->personas = 1;
\$usuario->rol = 'user';
\$usuario->perfilCompleto = false;
\$usuario->recetas_guardadas = [];
\$usuario->alergias = [];
\$usuario->preferencias = ['Vegetariana'];
\$usuario->metaCalorias = 14000;
\$usuario->save();
echo 'Usuario creado: test@test.com / 123456';
"
