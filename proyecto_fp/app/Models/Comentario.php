<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Comentario extends Model
{
    // // Asociación de la tabla 'comentarios' con el modelo.
    protected $table = 'comentarios';
    protected $fillable = ['comentario'];
    
    use HasFactory;

    
   /**
     * Get the libro that owns the comment.
     */
    public function libro(): BelongsTo
    {
        return $this->belongsTo(Libro::class,'foreign_key');
    } 
    
}
