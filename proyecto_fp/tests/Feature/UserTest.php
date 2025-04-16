<?php

namespace Tests\Feature; // Define el namespace para esta clase de prueba, indicando que pertenece a las pruebas de características.

use Illuminate\Foundation\Testing\RefreshDatabase; // Trait de Laravel para resetear la base de datos después de cada prueba.
use Tests\TestCase; // Clase base para las pruebas en Laravel.
use App\Models\User; // Modelo Eloquent para la tabla de usuarios.
use App\Models\Libro; // Modelo Eloquent para la tabla de libros.
use Illuminate\Support\Facades\Hash; // Facade de Laravel para el hash de contraseñas.

class UserTest extends TestCase // Define la clase UserTest que extiende TestCase, donde se definirán las pruebas relacionadas con la funcionalidad de los usuarios.
{
    use RefreshDatabase; // Utiliza el trait RefreshDatabase para asegurar un estado limpio de la base de datos en cada prueba.

    /**
     * Prueba que la página de registro se carga correctamente.
     */
    public function test_pagina_registro()
    {
        $response = $this->get(route('register')); // Realiza una petición GET a la ruta nombrada 'register'.
        $response->assertStatus(200); // Asegura que la respuesta tiene un código de estado HTTP 200 (OK), indicando que la página se cargó correctamente.
    }

    /**
     * Prueba el proceso de registro de un nuevo usuario.
     */
    public function test_nuevo_usuario_registro()
    {
        $response = $this->post('/register', [ // Realiza una petición POST a la ruta '/register' con los siguientes datos.
            'nombre' => 'Test User', // Simula el campo 'nombre' del formulario de registro.
            'email' => 'test@example.com', // Simula el campo 'email' del formulario de registro.
            'password' => 'password', // Simula el campo 'password' del formulario de registro.
            'password_confirmation' => 'password', // Simula el campo 'password_confirmation' del formulario de registro.
        ]);

        $response->assertRedirect(route('login', absolute: false)); // Asegura que la respuesta es una redirección a la ruta nombrada 'login'. 'absolute: false' indica que se espera una ruta relativa.
    }

    /**
     * Prueba que un usuario autenticado puede ver su perfil.
     * @test
     */
    public function test_usuario_ver_perfil()
    {
        // Crear usuario
        $user = User::create([ // Crea un nuevo usuario en la base de datos para simular un usuario existente.
            'nombre' => 'Carlos',
            'email' => 'carlos@example.com',
            'password' => Hash::make('password123'), // Hashea la contraseña antes de guardarla en la base de datos.
        ]);

        // Autenticación simulada
        $response = $this->actingAs($user)->get('/miperfil/' . $user->id); // Simula que el usuario creado está autenticado y realiza una petición GET a la ruta del perfil del usuario.

        // Verifica que accede correctamente
        $response->assertStatus(200); // Asegura que la respuesta tiene un código de estado HTTP 200 (OK), indicando que la página del perfil se cargó correctamente.
        // $response->assertSee($user->name); // o el contenido esperado en la vista // Línea comentada que podría usarse para verificar que el nombre del usuario aparece en la respuesta.
    }

    /**
     * Prueba que un usuario puede iniciar sesión con credenciales correctas.
     * @test
     */
    public function test_un_usuario_puede_iniciar_sesion_con_credenciales_correctas()
    {
        $user = User::factory()->create(); // Crea un usuario de prueba utilizando una factory.

        $response = $this->post('/login', [ // Realiza una petición POST a la ruta '/login' con las credenciales del usuario creado.
            'email' => $user->email,
            'password' => 'password', // Asume que la factory crea usuarios con la contraseña 'password' (por defecto).
        ]);

        $this->assertAuthenticated(); // Asegura que el usuario ha sido autenticado después de la petición de inicio de sesión.
        $response->assertRedirect(route('inicio', absolute: false)); // Asegura que la respuesta es una redirección a la ruta nombrada 'inicio'.
    }

    /**
     * Prueba que un usuario no autenticado no puede iniciar sesión con credenciales correctas.
     */
    public function test_usuario_no_autenticado_puede_iniciar_sesion_con_credenciales_correctas()
    {
        $user = User::factory()->create(); // Crea un usuario de prueba utilizando una factory.

        $this->post('/login', [ // Realiza una petición POST a la ruta '/login' con credenciales incorrectas.
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest(); // Asegura que el usuario NO ha sido autenticado después de la petición de inicio de sesión fallida.
    }

    /**
     * Prueba que un usuario autenticado puede modificar su perfil.
     * @test
     */
    public function test_usuario_modificar_perfil()
    {
        $user = User::factory()->create(); // Crea un usuario de prueba utilizando una factory.

        $response = $this
            ->actingAs($user) // Simula que el usuario creado está autenticado.
            ->post('/perfil/editar', [ // Realiza una petición POST a la ruta '/perfil/editar' con los nuevos datos del perfil.
                'nombre' => 'Test User',
                'email' => 'test@example.com',
                'password' => 'password',
            ]);

        $response
            ->assertSessionHasNoErrors(); // Asegura que no hay errores de validación en la sesión después de la petición.

        $user->refresh(); // Recarga los datos del usuario desde la base de datos para obtener los valores actualizados.

        $this->assertSame('Test User', $user->nombre); // Asegura que el nombre del usuario se ha actualizado correctamente.
        $this->assertSame('test@example.com', $user->email); // Asegura que el email del usuario se ha actualizado correctamente.
        $this->assertTrue(Hash::check('password', $user->password)); // Asegura que la contraseña del usuario se ha actualizado correctamente (verificando el hash).
    }

    /**
     * Prueba la funcionalidad de cierre de sesión de un usuario.
     */
    public function test_usuario_cierra_sesion()
    {
        $user = User::factory()->create(); // Crea un usuario de prueba utilizando una factory.

        $response = $this->actingAs($user)->post('/logout'); // Simula que el usuario está autenticado y realiza una petición POST a la ruta '/logout'.

        $this->assertGuest(); // Asegura que el usuario ya no está autenticado después de la petición de cierre de sesión.
        $response->assertRedirect('/'); // Asegura que la respuesta es una redirección a la ruta '/'.
    }

    /**
     * Prueba que un usuario autenticado puede borrar su perfil.
     * @test
     */
    public function test_usuario_borrar_perfil()
    {
        $user = User::factory()->create(); // Crea un usuario de prueba utilizando una factory.

        $response = $this
            ->actingAs($user) // Simula que el usuario creado está autenticado.
            ->post('/perfil/eliminando/', [ // Realiza una petición POST a la ruta '/perfil/eliminando/' con el ID del usuario a borrar.
                'id' => $user->id,
            ]);

        $response
            ->assertSessionHasNoErrors(); // Asegura que no hay errores de sesión después de la petición de borrado.

        $this->assertNull($user->fresh()); // Asegura que el usuario ya no existe en la base de datos después de ser borrado. 'fresh()' intenta recargar el modelo desde la base de datos y devuelve null si no se encuentra.
    }

    /**
     * Prueba la funcionalidad de un usuario para comentar en un libro.
     */
    public function test_usuario_comentario()
    {
        // usuario
        $user = User::factory()->create(); // Crea un usuario de prueba utilizando una factory.
        $this->actingAs($user); // Simula que el usuario creado está autenticado.

        // libro
        $libro = Libro::factory()->create(); // Crea un libro de prueba utilizando una factory.

        // comentario del libro
        $comentarioData = [ // Define los datos del comentario que se enviarán en la petición.
            'libro_id' => $libro->id,
            'usuario_id' => $user->id,
            'comentario' => 'Este es un comentario de prueba.',
        ];
        // Realizar la petición POST para crear el comentario (asumiendo la ruta nombrada 'comentar')
        $response = $this->post(route('comentar'), $comentarioData); // Realiza una petición POST a la ruta nombrada 'comentar' con los datos del comentario.

        // Aserciones
        $response->assertRedirect(); // Asumiendo que redirige a algún lugar después de comentar.
        $this->assertDatabaseHas('comentario', [ // Asegura que un registro con los datos del comentario se ha insertado en la tabla 'comentario'.
            'usuario_id' => $user->id,
            'libro_id' => $libro->id,
            'comentario' => 'Este es un comentario de prueba.',
        ]);
    }
}