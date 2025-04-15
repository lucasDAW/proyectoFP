<?php

namespace Tests\Feature;


use App\Models\User;
use App\Models\Libro;
use App\Models\Categoria;
use App\Models\Autor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

/**
 *  Flujo de prueba
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
    
    use RefreshDatabase;
    
    /** @test */
    public function ciclo_completo_usuario_publica_modifica_y_comenta_un_libro()
    {
        // 1. Registrar usuario
        $this->post('/register', [
            'nombre' => 'Mario',
            'email' => 'mario@example.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
        ])->assertRedirect(route('login'));

        $user = User::where('email', 'mario@example.com')->first();
        $this->actingAs($user);

        // 2. Modificar nombre
        $response = $this
            ->actingAs($user)
            ->post('/perfil/editar', [
            'nombre' => 'Mario Modificado',
            'email' => $user->email,
            'password' => 'secret123',
            ]);
        
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('usuario', [
            'id' => $user->id,
            'nombre' => 'Mario Modificado',
        ]);

        // 3. Publicar libro
        
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

        $libroPublicado = Libro::latest()->first();
        $this->assertDatabaseHas('archivos', [
            'usuario_id' => $user->id,
            'libro_id' => $libroPublicado->id,
            'archivo' => 'archivo/' . $archivo->hashName(),
            'portada' => 'portada/' . $portada->hashName(),
        ]);

        Storage::disk('archivos')->assertExists('archivo/' . $archivo->hashName());
        Storage::disk('archivos')->assertExists('portada/' . $portada->hashName());

        // 4. Modificar título y precio del libro
        $this->post('/libro/publicando', [
            'id' => $libroPublicado->id,
            'titulo' => 'Libro Modificado',
            'descripcion' => 'Descripción inicial',
            'categoriatext' => $categoria->id,
            'autorselect' => $autor->id,
            'portada' => $portada,
            'archivo' => $archivo,
            'fecha_lanzamiento' => '1954',
            'precio' => 20.00,
        ])->assertStatus(302);

        $this->assertDatabaseHas('libro', [
            'id' => $libroPublicado->id,
            'titulo' => 'Libro Modificado',
            'descripcion' => 'Descripción inicial',
            'fecha_lanzamiento' => '1954',
            'precio' => 20.00,
            'autor_id' => $autor->id,
            'categoria_id' => $categoria->id,
        ]);

        // 5. Añadir al carrito
        $this->get('/carrito/' . $libroPublicado->id)->assertRedirect();

        // 6. Comentar y valorar el libro
        $this->post(route('comentar'), [
            'libro_id' => $libroPublicado->id,
            'usuario_id' => $user->id,
            'comentario' => 'Excelente libro. Lo recomiendo.',
        ])->assertStatus(302);

        $this->assertDatabaseHas('comentario', [
            'libro_id' => $libroPublicado->id,
            'usuario_id' => $user->id,
            'comentario' => 'Excelente libro. Lo recomiendo.',
        ]);
    }

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
