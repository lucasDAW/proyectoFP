<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Libro extends Model
{
    use HasFactory;

    // Asociación de la tabla 'libros' con el modelo.
    protected $table = 'libro';
    
    // Definición de los atributos asignables en masa.
    protected $fillable = ['titulo','descripcion','autor','fecha_lanzamiento','precio'];
    
  /**
     * Get the comentarios for the libros.
     */
    public function comentarios(): HasMany
    {
        return $this->hasMany(Comentario::class);
    }
    
    public function escritor(): BelongsTo
    {
        return $this->belongsTo(Autor::class,'autor_id');
    }
    public function nombrecategoria(){
        return $this->belongsTo(Categoria::class);
    }
}
