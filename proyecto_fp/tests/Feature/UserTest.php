<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Libro;
use Illuminate\Support\Facades\Hash;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_pagina_registro()
    {
        $response = $this->get(route('register'));
        $response->assertStatus(200);
    }

    public function test_nuevo_usuario_registro()
    {
        $response = $this->post('/register', [
            'nombre' => 'Test User', // Usa el campo correcto
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect(route('login', absolute: false));
    }
    
     /** @test */
    public function test_usuario_ver_perfil()
    {
        // Crear usuario
        $user = User::create([
            'nombre' => 'Carlos',
            'email' => 'carlos@example.com',
            'password' => Hash::make('password123'),
        ]);

        // Autenticación simulada
        $response = $this->actingAs($user)->get('/miperfil/' . $user->id);

        // Verifica que accede correctamente
        $response->assertStatus(200);
//        $response->assertSee($user->name); // o el contenido esperado en la vista
    }
    
    /** @test */
    public function test_un_usuario_puede_iniciar_sesion_con_credenciales_correctas()
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('inicio', absolute: false));
    }
    
    public function test_usuario_no_autenticado_puede_iniciar_sesion_con_credenciales_correctas(){
        
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }
    
     /** @test */
    public function test_usuario_modificar_perfil()
    {
        
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->post('/perfil/editar', [
                'nombre' => 'Test User',
                'email' => 'test@example.com',
                'password' => 'password',
            ]);

        $response
            ->assertSessionHasNoErrors();
            

        $user->refresh();

        $this->assertSame('Test User', $user->nombre);
        $this->assertSame('test@example.com', $user->email);
        $this->assertTrue(Hash::check('password',$user->password));

    }
    
    public function test_usuario_cierra_sesion(){
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }
    
     /** @test */
    public function test_usuario_borrar_perfil()
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->post('/perfil/eliminando/', [
                'id' => $user->id,
            ]);

        $response
            ->assertSessionHasNoErrors();
            
        $this->assertNull($user->fresh());
    }
    
    public function test_usuario_comentario(){
        //usuario
        $user = User::factory()->create();
        $this->actingAs($user);


        //libro
        $libro = Libro::factory()->create();
        
        //comentario del libro
        $comentarioData = [
            'libro_id' => $libro->id,
            'usuario_id' => $user->id,
            'comentario' => 'Este es un comentario de prueba.',
        ];
         //Realizar la petición POST para crear el comentario (asumiendo la ruta /comentarios/crear)
        $response = $this->post(route('comentar'), $comentarioData);

        //Aserciones
        $response->assertRedirect(); // Asumiendo que redirige a algún lugar después de comentar
        $this->assertDatabaseHas('comentario', [
            'usuario_id' => $user->id,
            'libro_id' => $libro->id,
            'comentario' => 'Este es un comentario de prueba.',
        ]);


    }
   
    
}
