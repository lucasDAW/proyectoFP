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
        Schema::create('libros', function (Blueprint $table) {
            $table->id()->unique(); //Necesario para el ORM Eloquent
            $table->string('titulo',50);
            $table->text('descripcion');
            $table->string('autor');
            $table->integer('numero_paginas');
            $table->string('ISBN');
            $table->string('fecha_lanzamiento');
            $table->float('precio', $precision = 0.00);
            $table->timestamp('created_at')->nullable();
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
