<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile; // Importa la clase UploadedFile
use Illuminate\Support\Facades\Storage; // Para interactuar con el sistema de archivos

use Tests\TestCase;
use App\Models\Libro;
use App\Models\User;

class LibrosTest extends TestCase
{
        use RefreshDatabase;

    /**
     * A basic feature test example.
     */
   
 
    public function test_vista_publicar_libro(){
        $user = User::factory()->create();
        
//
        $response = $this->actingAs($user);
        $response= $this->get('/libro/publicar');
        $this->assertAuthenticated();
      
      
       $response->assertStatus(200);
   }
   public function test_publicar_libro(){
       
        //1. Preparación
        // - Crea un usuario autenticado
        $user = User::factory()->create();
        $this->actingAs($user);

        // - Datos del libro (válidos e inválidos)
        $datosValidos = [
            'titulo' => 'El Señor de los Anillos',
            'descripcion' => 'Una épica historia de fantasía.',
            'fecha_lanzamiento' => '2025', // Formato válido según tu regex
            'precio' => 25.99,
            'archivo' => UploadedFile::fake()->create('libro.pdf', 100, 'application/pdf'),
            'autorselect' => 1, // ID de un autor existente
            'categoriatext' => 1, // ID de una categoría existente
        ];

        $datosInvalidos = [
            'titulo' => '', // Campo obligatorio vacío
            'descripcion' => '', // Campo obligatorio vacío
            'fecha_lanzamiento' => '2025-03-15', // Formato inválido según tu regex
            'precio' => -10, // Valor inválido
            'archivo' => UploadedFile::fake()->create('imagen.jpg', 100, 'image/jpeg'), // Tipo de archivo incorrecto
        ];

        // 2. Ejecución
        // - Prueba con datos válidos
        Storage::fake('archivos'); // Simula el almacenamiento de archivos
        $response = $this->post('/libro/publicando', $datosValidos);

        // - Prueba con datos inválidos
        $responseInvalidos = $this->post('/libro/publicar', $datosInvalidos);

        // 3. Aserciones
        // - Datos válidos
        $response->assertStatus(302); // Redirección
        $response->assertSessionHasNoErrors(); // Sin errores de validación
        $this->assertDatabaseHas('libro', [
            'titulo' => 'El Señor de los Anillos',
            'descripcion' => 'Una épica historia de fantasía.',
            'precio' => 25.99,
            'fecha_lanzamiento' => '2025',
        ]);
        Storage::disk('archivos')->assertExists('archivo/libro.pdf'); // Verifica que el archivo se guardó

        // - Datos inválidos
        $responseInvalidos->assertStatus(302); // Redirección
        $responseInvalidos->assertSessionHasErrors([
            'titulo', 'descripcion', 'fecha_lanzamiento', 'precio', 'archivo'
        ]); // 
   }
   public function test_editar_libro(){
       $libro = Libro::factory()->create();
   }
 
}
