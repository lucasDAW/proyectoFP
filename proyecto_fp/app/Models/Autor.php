<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\hasMany;


class Autor extends Model
{
     /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    protected $table = 'autor';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nombre',
    ];
    
    public function libros(): hasMany
    {
        return $this->hasMany(Libro::class);
    }
}
