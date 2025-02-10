<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Libro;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');
        

        $response->assertStatus(200);
//        $response->assertSee('Inicio');
    }
    public function test_crear_libro()
   {
        $response= $this->post('/libro/publicando');
       // create a new libro instance with attributes
       $libro =new Libro();
       $libro->titulo ='Sample libro titulo';
       $libro->descripcion ='Sample libro descripcion';
       $libro->categoria_id =2;
       // check if you set the attributes correctly
       $this->assertEquals('Sample libro titulo', $libro->titulo);
       $this->assertEquals('Sample libro descripcion', $libro->descripcion);
       $this->assertEquals(2, $libro->categoria_id);
       $response->assertStatus(200);
   }
    public function test_vista_libro()
   {
        $response= $this->get('/libro/publicar');
        $this->assertAuthenticated();
       // create a new libro instance with attributes
      
      
       $response->assertStatus(200);
   }
    public function test_contacto_admin()
   {
         $response= $this->get('/contacto');


       // check if you set the attributes correctly
       $response->assertStatus(200);
   }
    public function test_autor_vista()
   {
         $response= $this->get('/autor');


       // check if you set the attributes correctly
       $response->assertStatus(200);
   }
}
