<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    //
    
      // Asociación de la tabla 'libros' con el modelo.
    protected $table = 'compras';
    
    // Definición de los atributos asignables en masa.
    protected $fillable = ['user_id','total_compra'];
    
    
}
