<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Alergia extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'alergias';

    protected $fillable = ['usuario_id', 'ingrediente_id'];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, null, '_id');
    }

    public function ingrediente()
    {
        return $this->belongsTo(Ingrediente::class, null, '_id');
    }
}
