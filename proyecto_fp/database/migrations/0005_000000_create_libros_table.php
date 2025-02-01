<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('libro', function (Blueprint $table) {
            $table->id()->unique(); //Necesario para el ORM Eloquent
            $table->string('titulo',50);
            $table->text('descripcion');
            $table->string('fecha_lanzamiento');
            $table->float('precio', $precision = 0.00);
            $table->string('autor_id')->foreignId('autor')->references('id')->on('autor');
            $table->foreignId('categoria_id')->references('id')->on('categoria');
        
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();         
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('libro');    
        
    }
};
