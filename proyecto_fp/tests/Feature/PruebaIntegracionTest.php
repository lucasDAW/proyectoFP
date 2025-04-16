<?php

namespace Tests\Feature; // Define el namespace para esta clase de prueba de características.

use App\Models\User; // Importa el modelo de usuario.
use App\Models\Libro; // Importa el modelo de libro.
use App\Models\Categoria; // Importa el modelo de categoría.
use App\Models\Autor; // Importa el modelo de autor.
use Illuminate\Foundation\Testing\RefreshDatabase; // Trait para resetear la base de datos después de cada prueba.
use Illuminate\Support\Facades\Hash; // Facade para el hash de contraseñas (aunque no se usa directamente en esta prueba).
use Illuminate\Support\Facades\Storage; // Facade para interactuar con el sistema de archivos.
use Illuminate\Http\UploadedFile; // Clase para simular archivos subidos.
use Tests\TestCase; // Clase base para las pruebas en Laravel.

/**
 * Flujo de prueba de integración completo para un usuario que registra, modifica su perfil,
 * publica un libro, modifica el libro, lo añade al carrito, comenta y valora.
 * -----------------------
 * Registrar un nuevo usuario (POST /register)
 * Modificar su nombre (POST /perfil/editar)
 * Publicar un libro (POST /libro/publicando)
 * Modificar el título y precio del libro
 * Añadir el libro al carrito (GET /carrito/{libro})
 * Comentar y valorar el libro (POST /usuario/libro/valorar)
 */
class PruebaIntegracionTest extends TestCase
{
    use RefreshDatabase; // Utiliza el trait RefreshDatabase para asegurar un estado limpio de la base de datos en cada prueba.

    /**
     * Prueba de integración que simula el ciclo completo de un usuario:
     * registrarse, modificar su nombre, publicar un libro, modificar el libro,
     * añadirlo al carrito y finalmente comentarlo.
     * @test
     */
    public function ciclo_completo_usuario_publica_modifica_y_comenta_un_libro()
    {
        // 1. Registrar usuario
        $this->post('/register', [ // Realiza una petición POST a la ruta de registro con datos de prueba.
            'nombre' => 'Mario',
            'email' => 'mario@example.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
        ])->assertRedirect(route('login')); // Asegura que la respuesta es una redirección a la ruta de inicio de sesión después del registro.

        $user = User::where('email', 'mario@example.com')->first(); // Obtiene el usuario recién registrado de la base de datos.
        $this->actingAs($user); // Simula que este usuario está autenticado para las siguientes peticiones.

        // 2. Modificar nombre
        $response = $this
            ->actingAs($user) // Asegura que la petición se realiza como el usuario autenticado.
            ->post('/perfil/editar', [ // Realiza una petición POST a la ruta de edición de perfil con el nuevo nombre.
                'nombre' => 'Mario Modificado',
                'email' => $user->email,
                'password' => 'secret123', // Se requiere la contraseña para la modificación (aunque no se cambie aquí).
            ]);

        $response->assertSessionHasNoErrors(); // Asegura que no hay errores de validación en la sesión después de la modificación del perfil.

        $this->assertDatabaseHas('usuario', [ // Asegura que el nombre del usuario se ha actualizado en la base de datos.
            'id' => $user->id,
            'nombre' => 'Mario Modificado',
        ]);

        // 3. Publicar libro
        $categoria = Categoria::factory()->create(['nombre' => 'Ficción']); // Crea una categoría de prueba usando una factory.
        $autor = Autor::factory()->create(['nombre' => 'J.R.R. Tolkien']); // Crea un autor de prueba usando una factory.
        $portada = UploadedFile::fake()->image('portada.jpg'); // Simula la subida de un archivo de imagen para la portada.
        $archivo = UploadedFile::fake()->create('libro.pdf', 100); // Simula la subida de un archivo PDF para el libro.

        $libroData = [ // Define los datos del libro a publicar.
            'titulo' => 'El Señor de los Anillos',
            'descripcion' => 'Una épica aventura de fantasía.',
            'fecha_lanzamiento' => '1954',
            'precio' => 25.99,
            'categoriatext' => $categoria->id, // Envía el ID de la categoría.
            'autorselect' => $autor->id, // Envía el ID del autor.
            'portada' => $portada,
            'archivo' => $archivo,
        ];

        $response = $this->post('/libro/publicando', $libroData); // Realiza una petición POST a la ruta de publicación de libros con los datos del libro.

        $response->assertRedirect(route('inicio')) // Asegura que la respuesta es una redirección a la ruta de inicio después de la publicación.
            ->assertSessionHas('mensaje', 'Se ha publicado el libro de forma correcta'); // Asegura que la sesión tiene un mensaje de éxito.

        $this->assertDatabaseHas('libro', [ // Asegura que los datos básicos del libro se han guardado en la base de datos.
            'titulo' => 'El Señor de los Anillos',
            'descripcion' => 'Una épica aventura de fantasía.',
            'fecha_lanzamiento' => '1954',
            'precio' => 25.99,
            'autor_id' => $autor->id,
            'categoria_id' => $categoria->id,
        ]);

        $libroPublicado = Libro::latest()->first(); // Obtiene el último libro publicado de la base de datos.
        $this->assertDatabaseHas('archivos', [ // Asegura que los nombres de los archivos (portada y archivo del libro) se han guardado en la tabla de archivos.
            'usuario_id' => $user->id,
            'libro_id' => $libroPublicado->id,
            'archivo' => 'archivo/' . $archivo->hashName(), // Verifica el nombre del archivo guardado.
            'portada' => 'portada/' . $portada->hashName(), // Verifica el nombre de la portada guardada.
        ]);

        Storage::disk('archivos')->assertExists('archivo/' . $archivo->hashName()); // Asegura que el archivo del libro existe en el disco de almacenamiento 'archivos'.
        Storage::disk('archivos')->assertExists('portada/' . $portada->hashName()); // Asegura que la portada existe en el disco de almacenamiento 'archivos'.

        // 4. Modificar título y precio del libro
        $this->post('/libro/publicando', [ // Realiza otra petición POST a la misma ruta (asumiendo que se usa para crear y actualizar).
            'id' => $libroPublicado->id, // Incluye el ID para indicar que se está modificando un libro existente.
            'titulo' => 'Libro Modificado',
            'descripcion' => 'Descripción inicial',
            'categoriatext' => $categoria->id,
            'autorselect' => $autor->id,
            'portada' => $portada, // Se podría simular una nueva portada si fuera necesario.
            'archivo' => $archivo, // Se podría simular un nuevo archivo si fuera necesario.
            'fecha_lanzamiento' => '1954',
            'precio' => 20.00,
        ])->assertStatus(302); // Asegura una redirección después de la modificación.

        $this->assertDatabaseHas('libro', [ // Asegura que el título y el precio del libro se han actualizado en la base de datos.
            'id' => $libroPublicado->id,
            'titulo' => 'Libro Modificado',
            'descripcion' => 'Descripción inicial',
            'fecha_lanzamiento' => '1954',
            'precio' => 20.00,
            'autor_id' => $autor->id,
            'categoria_id' => $categoria->id,
        ]);

        // 5. Añadir al carrito
        $this->get('/carrito/' . $libroPublicado->id)->assertRedirect(); // Realiza una petición GET para añadir el libro al carrito y asegura una redirección (la lógica del carrito no se prueba en detalle aquí).

        // 6. Comentar y valorar el libro
        $this->post(route('comentar'), [ // Realiza una petición POST a la ruta para comentar un libro.
            'libro_id' => $libroPublicado->id,
            'usuario_id' => $user->id,
            'comentario' => 'Excelente libro. Lo recomiendo.',
        ])->assertStatus(302); // Asegura una redirección después de comentar.

        $this->assertDatabaseHas('comentario', [ // Asegura que el comentario se ha guardado en la base de datos.
            'libro_id' => $libroPublicado->id,
            'usuario_id' => $user->id,
            'comentario' => 'Excelente libro. Lo recomiendo.',
        ]);
    }

    /**
     * Una prueba de característica básica de ejemplo (generada por Laravel).
     */
    public function test_example(): void
    {
        $response = $this->get('/'); // Realiza una petición GET a la ruta '/'.

        $response->assertStatus(200); // Asegura que la respuesta tiene un código de estado HTTP 200 (OK).
    }
}