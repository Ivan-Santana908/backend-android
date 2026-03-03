<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class RecetaGuardada extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'recetas_guardadas';

    protected $fillable = ['usuario_id', 'receta_id'];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id', '_id');
    }

    public function receta()
    {
        return $this->belongsTo(Receta::class, 'receta_id', '_id');
    }
}
