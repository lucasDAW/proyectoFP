<?php

namespace Tests\Feature; // Define el namespace para esta clase de prueba de características.

use App\Models\Autor; // Importa el modelo de Autor.
use App\Models\Categoria; // Importa el modelo de Categoria.
use App\Models\Libro; // Importa el modelo de Libro.
use App\Models\User; // Importa el modelo de User.
use Illuminate\Foundation\Testing\RefreshDatabase; // Trait para resetear la base de datos después de cada prueba.
use Illuminate\Http\UploadedFile; // Clase para simular archivos subidos (como imágenes y PDFs).
use Illuminate\Support\Facades\Storage; // Facade para interactuar con el sistema de archivos (para pruebas de almacenamiento).
use Tests\TestCase; // Clase base para las pruebas en Laravel.

class LibroTest extends TestCase // Define la clase LibroTest que extiende TestCase, donde se definirán las pruebas relacionadas con la funcionalidad de los libros.
{
    use RefreshDatabase; // Utiliza el trait RefreshDatabase para asegurar un estado limpio de la base de datos en cada prueba.

    protected function setUp(): void // Método que se ejecuta antes de cada prueba.
    {
        parent::setUp(); // Llama al método setUp de la clase padre.
        // Crear un usuario autenticado por defecto para las pruebas que lo requieran
        $this->actingAs($this->user = User::factory()->create()); // Crea un usuario de prueba y lo autentica para las pruebas que necesiten un usuario logueado. El usuario se guarda en la propiedad $this->user.
    }

    /**
     * Prueba la creación de un nuevo libro.
     */
    public function test_crear_nuevo_libro()
    {
        // Crear modelos de categoría y autor para asociarlos al libro.
        $categoria = Categoria::factory()->create(['nombre' => 'Ficción']);
        $autor = Autor::factory()->create(['nombre' => 'J.R.R. Tolkien']);
        // Simular la subida de archivos de portada y libro.
        $portada = UploadedFile::fake()->image('portada.jpg');
        $archivo = UploadedFile::fake()->create('libro.pdf', 100);

        // Datos del libro que se enviarán en la petición de creación.
        $libroData = [
            'titulo' => 'El Señor de los Anillos',
            'descripcion' => 'Una épica aventura de fantasía.',
            'fecha_lanzamiento' => '1954',
            'precio' => 25.99,
            'categoriatext' => $categoria->id, // ID de la categoría seleccionada.
            'autorselect' => $autor->id, // ID del autor seleccionado.
            'portada' => $portada, // Archivo de portada simulado.
            'archivo' => $archivo, // Archivo del libro simulado.
        ];

        // Realizar una petición POST a la ruta '/libro/publicando' con los datos del libro.
        $response = $this->post('/libro/publicando', $libroData);

        // Aserciones para verificar que la creación fue exitosa.
        $response->assertRedirect(route('inicio')) // Asegura que la respuesta es una redirección a la ruta 'inicio'.
            ->assertSessionHas('mensaje', 'Se ha publicado el libro de forma correcta'); // Asegura que la sesión contiene un mensaje de éxito.

        // Asegura que los datos del libro se han guardado en la base de datos.
        $this->assertDatabaseHas('libro', [
            'titulo' => 'El Señor de los Anillos',
            'descripcion' => 'Una épica aventura de fantasía.',
            'fecha_lanzamiento' => '1954',
            'precio' => 25.99,
            'autor_id' => $autor->id,
            'categoria_id' => $categoria->id,
        ]);

        // Obtener el último libro creado para verificar los archivos asociados.
        $libro = Libro::latest()->first();
        // Asegura que los nombres de los archivos se han guardado en la tabla 'archivos'.
        $this->assertDatabaseHas('archivos', [
            'usuario_id' => $this->user->id,
            'libro_id' => $libro->id,
            'archivo' => 'archivo/' . $archivo->hashName(), // Verifica el nombre del archivo.
            'portada' => 'portada/' . $portada->hashName(), // Verifica el nombre de la portada.
        ]);

        // Asegura que los archivos existen en el disco de almacenamiento 'archivos'.
        Storage::disk('archivos')->assertExists('archivo/' . $archivo->hashName());
        Storage::disk('archivos')->assertExists('portada/' . $portada->hashName());
    }

    /**
     * Prueba la visualización de los detalles de un libro.
     */
    public function test_detalles_libro()
    {
        // Crear modelos de categoría, autor y un libro asociado.
        $categoria = Categoria::factory()->create();
        $autor = Autor::factory()->create();
        $libro = Libro::factory()->create(['categoria_id' => $categoria->id, 'autor_id' => $autor->id]);

        // Realizar una petición GET a la ruta para ver los detalles del libro.
        $response = $this->get('/libro/detalle/' . $libro->id); // Asume que esta es la ruta para los detalles del libro.

        // Asegura que la respuesta tiene un código de estado HTTP 200 (OK).
        $response->assertOk();
    }

    /**
     * Prueba la funcionalidad de editar un libro por un administrador.
     */
    public function test_editar_libro()
    {
        // Crear un usuario administrador.
        $user = User::factory()->create(['rol' => 2]); // Asume que 'rol' con valor 2 indica un administrador.
        $this->actingAs($user); // Autenticar al usuario administrador para la prueba.

        // 1. Crear un libro existente (puede ser creado por cualquier usuario).
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

        $this->post('/libro/publicando', $libroOriginalData); // Publicar el libro original.
        $libroExistente = Libro::latest()->first(); // Obtener el libro recién publicado.

        // Asegurarse de que el libro original se creó correctamente (aserciones).
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

        // 2. Datos para editar el libro por el administrador.
        $nuevaCategoria = Categoria::factory()->create(['nombre' => 'Ciencia Ficción']);
        $nuevoAutor = Autor::factory()->create(['nombre' => 'Isaac Asimov']);
        $nuevaPortada = UploadedFile::fake()->image('nueva_portada.png');
        $nuevoArchivo = UploadedFile::fake()->create('nuevo_libro.pdf', 120);

        $libroDataEditada = [
            'id' => $libroExistente->id, // Importante: incluir el ID del libro a editar.
            'titulo' => 'Orgullo y Prejuicio (Edición Admin)',
            'descripcion' => 'Edición especial por el administrador.',
            'fecha_lanzamiento' => '2025',
            'precio' => 29.99,
            'categoriatext' => $nuevaCategoria->id,
            'autorselect' => $nuevoAutor->id,
            'portada' => $nuevaPortada,
            'archivo' => $nuevoArchivo,
        ];

        // 3. Realizar la petición de edición como el usuario administrador.
        $responseEdit = $this->post('/libro/publicando', $libroDataEditada);

        // 4. Aserciones para verificar que la edición fue exitosa.
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
            'usuario_id' => $user->id, // El usuario admin realizó la edición.
            'archivo' => 'archivo/' . $nuevoArchivo->hashName(),
            'portada' => 'portada/' . $nuevaPortada->hashName(),
        ]);

        Storage::disk('archivos')->assertExists('archivo/' . $nuevoArchivo->hashName());
        Storage::disk('archivos')->assertExists('portada/' . $nuevaPortada->hashName());
    }

    /**
     * Prueba la eliminación de un libro por un administrador.
     */
    public function test_eliminar_libro()
   {
        // 1. Crear un usuario administrador
        $adminUser = User::factory()->create(['rol' => 2]);
        $this->actingAs($adminUser);

        // 2. Crear un libro
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

        // Obtener el nombre del archivo asociado al libro que se va a eliminar
        $archivoNombre = \App\Models\Archivo::where('libro_id', $libroExistente->id)->value('archivo');
        $portadaNombre = \App\Models\Archivo::where('libro_id', $libroExistente->id)->value('portada');

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
            'archivo' => $archivoNombre,
            'portada' => $portadaNombre,
        ]);
        Storage::disk('archivos')->assertExists($archivoNombre);
        Storage::disk('archivos')->assertExists($portadaNombre);

        // 3. Realizar la petición GET para borrar (mostrar confirmación)
        $responseBorrar = $this->get("/libro/borrar/{$libroExistente->id}");
        $responseBorrar->assertStatus(200);

        // 4. Realizar la petición POST para confirmar la eliminación
        $responseConfirmar = $this->post('/libro/borrar/confirmar', ['id' => $libroExistente->id]);

        // 5. Aserciones
        $responseConfirmar->assertRedirect(route('inicio'))
            ->assertSessionHas('mensaje', 'Se ha eliminado el libro de forma correcta');

        $this->assertDatabaseMissing('libro', ['id' => $libroExistente->id]);
        // Asumo que también eliminas los archivos relacionados al borrar el libro
        Storage::disk('archivos')->assertMissing($archivoNombre);
        Storage::disk('archivos')->assertMissing($portadaNombre);
    }

    // Helper function to create a test image for the post.
    private function create_test_image()
    {
        // Create a mock image file using Laravel's UploadedFile class.
        $file = UploadedFile::fake()->image('test_image.jpg');

        // Return the path to the temporary image file.
        return $file;
    }

    // Helper function to create a test file for the post.
    private function create_test_file()
    {
        // Create a mock image file using Laravel's UploadedFile class.
        $file = UploadedFile::fake()->image('test_file.pdf');

        // Return the path to the temporary image file.
        return $file;
    }
}