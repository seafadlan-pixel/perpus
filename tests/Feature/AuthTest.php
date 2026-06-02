<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_can_view_registration_form()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertSee('Register');
        $response->assertSee('Full Name');
    }

    /** @test */
    public function guests_can_register_as_visitor()
    {
        $response = $this->post('/register', [
            'name' => 'Fadlan Test',
            'email' => 'fadlan@test.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'name' => 'Fadlan Test',
            'email' => 'fadlan@test.com',
            'role' => 'visitor',
        ]);
    }

    /** @test */
    public function registration_requires_matching_passwords()
    {
        $response = $this->post('/register', [
            'name' => 'Fadlan Test',
            'email' => 'fadlan@test.com',
            'password' => 'password123',
            'password_confirmation' => 'different_password',
        ]);

        $response->assertSessionHasErrors('password');
        $this->assertDatabaseMissing('users', [
            'email' => 'fadlan@test.com',
        ]);
    }

    /** @test */
    public function registered_users_can_login()
    {
        $user = User::factory()->create([
            'email' => 'visitor@test.com',
            'password' => bcrypt('password123'),
            'role' => 'visitor',
        ]);

        $response = $this->post('/login', [
            'email' => 'visitor@test.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticatedAs($user);
    }
}
