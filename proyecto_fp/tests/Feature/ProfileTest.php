<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_is_displayed(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get('/perfil/editar/');

        $response->assertOk();
    }

    public function test_profile_information_can_be_updated(): void
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

    

    public function test_user_can_delete_their_account(): void
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

   
}
