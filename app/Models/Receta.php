<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Receta extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'recetas';

    protected $fillable = [
        'titulo',
        'descripcion',
        'calorias_porcion',
        'imagen',
        'tiempo_preparacion',
        'tiempo_coccion',
        'porciones',
        'dificultad',
        'tipo',
        'ingredientes',
        'pasos',
        'autor'
    ];

    // Desactivar timestamps
    public $timestamps = false;

    /**
     * Accessor para imagen - devuelve URL completa
     */
    protected $appends = ['imagen_url'];

    public function getImagenUrlAttribute()
    {
        if (empty($this->imagen)) {
            return null;
        }

        // Si ya tiene protocolo (http/https), retornarla tal cual
        if (preg_match('/^https?:\/\//', $this->imagen)) {
            return $this->imagen;
        }

        // Construir URL completa con el host del servidor
        $baseUrl = request()->getSchemeAndHttpHost();
        
        // Limpiar la ruta
        $path = ltrim($this->imagen, '/');
        
        // Si la ruta empieza con "imagenes/", reemplazar por "storage/images/recipes/"
        if (str_starts_with($path, 'imagenes/')) {
            $filename = basename($path);
            $extension = pathinfo($filename, PATHINFO_EXTENSION);
            
            // Mapear nombres de archivos viejos a nuevos
            $nameWithoutExt = pathinfo($filename, PATHINFO_FILENAME);
            $path = "storage/images/recipes/{$nameWithoutExt}.png";
        }
        
        return "{$baseUrl}/{$path}";
    }

    public function ingredientes()
    {
        return $this->embedsMany(Ingrediente::class, 'ingredientes');
    }

    // Relación con el usuario creador
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id', '_id');
    }

    // 🔴 Scope: recetas que contienen ingredientes peligrosos para el usuario
    public function scopeContieneAlergenosPara($query, Usuario $usuario)
    {
        return $query->whereRaw([
            'ingredientes' => [
                '$elemMatch' => [
                    'nombre' => ['$in' => $usuario->getAlergias()]
                ]
            ]
        ]);
    }

    // 🟢 Scope: recetas seguras (sin ingredientes peligrosos)
    public function scopeSegurasPara($query, Usuario $usuario)
    {
        return $query->whereRaw([
            'ingredientes' => [
                '$not' => [
                    '$elemMatch' => [
                        'nombre' => ['$in' => $usuario->getAlergias()]
                    ]
                ]
            ]
        ]);
    }

    // 🔁 Métodos estáticos que usan los scopes correctamente
    public static function contieneAlergenosPara(Usuario $usuario)
    {
        return self::query()->contieneAlergenosPara($usuario);
    }

    public static function segurasPara(Usuario $usuario)
    {
        return self::query()->segurasPara($usuario);
    }
}
