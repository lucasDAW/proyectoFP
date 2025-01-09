<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Libro extends Model
{
    use HasFactory;

    // Asociación de la tabla 'libros' con el modelo.
    protected $table = 'libros';
    
    // Definición de los atributos asignables en masa.
    protected $fillable = ['titulo','descripcion','autor','numero_paginas',
        'ISBN','fecha_lanzamiento','precio'];
    
  /**
     * Get the comentarios for the libros.
     */
    public function comentarios(): HasMany
    {
        return $this->hasMany(Comentario::class);
    }
}
