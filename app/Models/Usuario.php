<?php

namespace App\Models;

use MongoDB\Laravel\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Usuario extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $connection = 'mongodb';
    protected $collection = 'usuarios';

    protected $fillable = [
        'nombre',
        'email',
        'password',
        'personas',
        'rol',
        'recetas_guardadas',
        'alergias',
        'preferencias',
        'metaCalorias',
        'perfilCompleto',
        'planes_semanales',
        'listas_de_compra'
    ];

    protected $hidden = ['password'];

protected $casts = [
    'alergias' => 'array',
    'preferencias' => 'array',
    'recetas_guardadas' => 'array',
    'planes_semanales' => 'array',
    'listas_de_compra' => 'array',
    'metaCalorias' => 'integer',
    'perfilCompleto' => 'boolean',
];


    // JWT required methods
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    // Relaciones y getters personalizados
    public function recetas()
    {
        return $this->hasMany(Receta::class, 'usuario_id', '_id');
    }

    public function getRecetasGuardadas()
    {
        return $this->recetas_guardadas ?? [];
    }

    public function getAlergias()
    {
        return $this->alergias ?? [];
    }

    public function getPlanesSemanales()
    {
        return $this->planes_semanales ?? [];
    }

    public function getListasDeCompra()
    {
        return $this->listas_de_compra ?? [];
    }
}
