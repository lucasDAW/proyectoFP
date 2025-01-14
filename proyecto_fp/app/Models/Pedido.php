<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    
    // Asociación de la tabla 'libros' con el modelo.
    protected $table = 'pedidos';
    
    // Definición de los atributos asignables en masa.
    protected $fillable = ['libro_id','precio'];
}
