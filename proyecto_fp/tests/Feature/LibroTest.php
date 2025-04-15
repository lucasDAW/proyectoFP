<?php

namespace Tests\Feature;

use App\Models\Autor;
use App\Models\Categoria;
use App\Models\Libro;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class LibroTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Crear un usuario autenticado por defecto para las pruebas que lo requieran
        $this->actingAs($this->user = User::factory()->create());
    }

    public function test_crear_nuevo_libro()
    {
        $categoria = Categoria::factory()->create(['nombre' => 'Ficción']);
        $autor = Autor::factory()->create(['nombre' => 'J.R.R. Tolkien']);
        $portada = UploadedFile::fake()->image('portada.jpg');
        $archivo = UploadedFile::fake()->create('libro.pdf', 100);        
        
        $libroData = [
            'titulo' => 'El Señor de los Anillos',
            'descripcion' => 'Una épica aventura de fantasía.',
            'fecha_lanzamiento' => '1954',
            'precio' => 25.99,
            'categoriatext' => $categoria->id,
            'autorselect' => $autor->id,
            'portada' => $portada,
            'archivo' => $archivo,
        ];

        $response = $this->post('/libro/publicando', $libroData);

        $response->assertRedirect(route('inicio'))
            ->assertSessionHas('mensaje', 'Se ha publicado el libro de forma correcta');

        $this->assertDatabaseHas('libro', [
            'titulo' => 'El Señor de los Anillos',
            'descripcion' => 'Una épica aventura de fantasía.',
            'fecha_lanzamiento' => '1954',
            'precio' => 25.99,
            'autor_id' => $autor->id,
            'categoria_id' => $categoria->id,
        ]);

        $libro = Libro::latest()->first();
        $this->assertDatabaseHas('archivos', [
            'usuario_id' => $this->user->id,
            'libro_id' => $libro->id,
            'archivo' => 'archivo/' . $archivo->hashName(),
            'portada' => 'portada/' . $portada->hashName(),
        ]);

        Storage::disk('archivos')->assertExists('archivo/' . $archivo->hashName());
        Storage::disk('archivos')->assertExists('portada/' . $portada->hashName());
   
    }

    public function test_detalles_libro()
    {

        $categoria = Categoria::factory()->create();
        $autor = Autor::factory()->create();
        $libro = Libro::factory()->create(['categoria_id' => $categoria->id, 'autor_id' => $autor->id]);

        $response = $this->get('/libro/detalle/' . $libro->id); // Cambia la URL aquí

        $response->assertOk();
           
    }

    public function test_editar_libro()
    {
        
        $user = User::factory()->create(['rol' => 2]); // Asumiendo que 'rol' es un campo integer
        $this->actingAs($user);

        // 1. Crear un libro existente (puede ser creado por cualquier usuario)
        $categoriaOriginal = Categoria::factory()->create(['nombre' => 'Drama']);
        $autorOriginal = Autor::factory()->create(['nombre' => 'Jane Austen']);
        $portadaOriginal = UploadedFile::fake()->image('org_portada.jpg');
        $archivoOriginal = UploadedFile::fake()->create('org_libro.pdf', 150);

        $libroOriginalData = [
            'titulo' => 'Orgullo y Prejuicio',
            'descripcion' => 'Una novela clásica sobre el amor y la sociedad.',
            'fecha_lanzamiento' => '1813',
            'precio' => 15.99,
            'categoriatext' => $categoriaOriginal->id,
            'autorselect' => $autorOriginal->id,
            'portada' => $portadaOriginal,
            'archivo' => $archivoOriginal,
        ];

        $this->post('/libro/publicando', $libroOriginalData);
        $libroExistente = Libro::latest()->first();
        
        
         // Asegurarse de que el libro original se creó correctamente
        $this->assertDatabaseHas('libro', [
            'id' => $libroExistente->id,
            'titulo' => 'Orgullo y Prejuicio',
            'descripcion' => 'Una novela clásica sobre el amor y la sociedad.',
            'fecha_lanzamiento' => '1813',
            'precio' => 15.99,
            'autor_id' => $autorOriginal->id,
            'categoria_id' => $categoriaOriginal->id,
        ]);
        
        $this->assertDatabaseHas('archivos', [
            'libro_id' => $libroExistente->id,
            'archivo' => 'archivo/' . $archivoOriginal->hashName(),
            'portada' => 'portada/' . $portadaOriginal->hashName(),
        ]);
        Storage::disk('archivos')->assertExists('archivo/' . $archivoOriginal->hashName());
        Storage::disk('archivos')->assertExists('portada/' . $portadaOriginal->hashName());

        // 2. Datos para editar el libro por el administrador
        $nuevaCategoria = Categoria::factory()->create(['nombre' => 'Ciencia Ficción']);
        $nuevoAutor = Autor::factory()->create(['nombre' => 'Isaac Asimov']);
        $nuevaPortada = UploadedFile::fake()->image('nueva_portada.png');
        $nuevoArchivo = UploadedFile::fake()->create('nuevo_libro.pdf', 120);

        $libroDataEditada = [
            'id' => $libroExistente->id,
            'titulo' => 'Orgullo y Prejuicio (Edición Admin)',
            'descripcion' => 'Edición especial por el administrador.',
            'fecha_lanzamiento' => '2025',
            'precio' => 29.99,
            'categoriatext' => $nuevaCategoria->id,
            'autorselect' => $nuevoAutor->id,
            'portada' => $nuevaPortada,
            'archivo' => $nuevoArchivo,
        ];

        // 3. Realizar la petición de edición como el usuario administrador
        $responseEdit = $this->post('/libro/publicando', $libroDataEditada);

        // 4. Aserciones para verificar que la edición fue exitosa
        $responseEdit->assertRedirect(route('inicio'))
            ->assertSessionHas('mensaje', 'Se ha modificado el libro de forma correcta');

        $this->assertDatabaseHas('libro', [
            'id' => $libroExistente->id,
            'titulo' => 'Orgullo y Prejuicio (Edición Admin)',
            'descripcion' => 'Edición especial por el administrador.',
            'fecha_lanzamiento' => '2025',
            'precio' => 29.99,
            'autor_id' => $nuevoAutor->id,
            'categoria_id' => $nuevaCategoria->id,
        ]);

        $this->assertDatabaseHas('archivos', [
            'libro_id' => $libroExistente->id,
            'usuario_id' => $user->id, // El usuario admin realizó la edición
            'archivo' => 'archivo/' . $nuevoArchivo->hashName(),
            'portada' => 'portada/' . $nuevaPortada->hashName(),
        ]);

        Storage::disk('archivos')->assertExists('archivo/' . $nuevoArchivo->hashName());
        Storage::disk('archivos')->assertExists('portada/' . $nuevaPortada->hashName());
    }

    public function test_eliminar_libro()
    {
          // 1. Crear un usuario administrador
        $adminUser = User::factory()->create(['rol' => 2]);
        $this->actingAs($adminUser);

        // 2. Crear un libro
        // 1. Crear un libro existente (puede ser creado por cualquier usuario)
        $categoriaOriginal = Categoria::factory()->create(['nombre' => 'Drama']);
        $autorOriginal = Autor::factory()->create(['nombre' => 'Jane Austen']);
        $portadaOriginal = UploadedFile::fake()->image('org_portada.jpg');
        $archivoOriginal = UploadedFile::fake()->create('org_libro.pdf', 150);

        $libroOriginalData = [
            'titulo' => 'Orgullo y Prejuicio',
            'descripcion' => 'Una novela clásica sobre el amor y la sociedad.',
            'fecha_lanzamiento' => '1813',
            'precio' => 15.99,
            'categoriatext' => $categoriaOriginal->id,
            'autorselect' => $autorOriginal->id,
            'portada' => $portadaOriginal,
            'archivo' => $archivoOriginal,
        ];

        $this->post('/libro/publicando', $libroOriginalData);
        $libroExistente = Libro::latest()->first();
        
        
         // Asegurarse de que el libro original se creó correctamente
        $this->assertDatabaseHas('libro', [
            'id' => $libroExistente->id,
            'titulo' => 'Orgullo y Prejuicio',
            'descripcion' => 'Una novela clásica sobre el amor y la sociedad.',
            'fecha_lanzamiento' => '1813',
            'precio' => 15.99,
            'autor_id' => $autorOriginal->id,
            'categoria_id' => $categoriaOriginal->id,
        ]);
        
        $this->assertDatabaseHas('archivos', [
            'libro_id' => $libroExistente->id,
            'archivo' => 'archivo/' . $archivoOriginal->hashName(),
            'portada' => 'portada/' . $portadaOriginal->hashName(),
        ]);
        Storage::disk('archivos')->assertExists('archivo/' . $archivoOriginal->hashName());
        Storage::disk('archivos')->assertExists('portada/' . $portadaOriginal->hashName());

        // 3. Realizar la petición GET para borrar (mostrar confirmación)
        $responseBorrar = $this->get("/libro/borrar/{$libroExistente->id}");
        $responseBorrar->assertStatus(200); // Asegúrate de que la página de confirmación se muestra

        // 4. Realizar la petición POST para confirmar la eliminación
        $responseConfirmar = $this->post('/libro/borrar/confirmar',['id'=>$libroExistente->id]);

        // 5. Aserciones
        $responseConfirmar->assertRedirect(route('inicio'))
            ->assertSessionHas('mensaje', 'Se ha eliminado el libro de forma correcta');

        $this->assertDatabaseMissing('libro', ['id' => $libroExistente->id]);
        // Asumo que también eliminas los archivos relacionados al borrar el libro
        Storage::disk('archivos')->assertMissing('archivo/libro_para_eliminar.pdf');
        Storage::disk('archivos')->assertMissing('portada/portada_para_eliminar.jpg');
    
    }    
    // Helper function to create a test image for the post
   private function create_test_image()
   {
       // Create a mock image file using Laravel's UploadedFile class
       $file = UploadedFile::fake()->image('test_image.jpg');

       // Return the path to the temporary image file
       return $file;
   }
   
   // Helper function to create a test image for the post
   private function create_test_file()
   {
       // Create a mock image file using Laravel's UploadedFile class
       $file = UploadedFile::fake()->image('test_file.pdf');

       // Return the path to the temporary image file
       return $file;
   }
}