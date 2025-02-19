<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Libro;

class LoginTest extends TestCase
{
        use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');
        

        $response->assertStatus(200);
//        $response->assertSee('Inicio');
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
