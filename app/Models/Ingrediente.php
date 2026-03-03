<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Ingrediente extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'ingredientes';

    protected $fillable = [
        'nombre',
        'unidad'
    ];

    // Relación con recetas
    public function recetas()
    {
        return $this->belongsToMany(Receta::class, null, 'ingrediente_id', '_id');
    }

    public function alergias()
    {
        return $this->hasMany(Alergia::class, null, '_id', 'ingrediente_id');
    }
}
