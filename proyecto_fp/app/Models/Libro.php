<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Libro extends Model
{
    use HasFactory;

    // Asociación de la tabla 'talleres' con el modelo.
    protected $table = 'libros';
    
    // Definición de los atributos asignables en masa.
    protected $fillable = ['titulo','descripcion','autor','numero_paginas',
        'ISBN','fecha_lanzamiento','precio'];
    
  
}
