<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    #[\PHPUnit\Framework\Attributes\Test]
    public function login_page_is_accessible()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('Sign In');
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function registration_page_is_accessible()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response->assertSee('Create Account');
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function user_can_register_with_valid_data()
    {
        $userData = [
            'name' => 'New User',
            'email' => 'newuser@example.com',
            'phone' => '9876543210',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->post('/register', $userData);
        $response->assertRedirect('/cars');

        $this->assertDatabaseHas('users', [
            'email' => 'newuser@example.com',
            'role' => 'customer',
        ]);
        $this->assertAuthenticated();
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function user_cannot_register_with_existing_email()
    {
        User::create([
            'name' => 'Existing User',
            'email' => 'duplicate@example.com',
            'password' => bcrypt('password123'),
        ]);

        $userData = [
            'name' => 'Another User',
            'email' => 'duplicate@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->post('/register', $userData);
        $response->assertSessionHasErrors(['email']);
        $this->assertGuest();
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function user_can_login_with_correct_credentials()
    {
        $user = User::create([
            'name' => 'Test Login',
            'email' => 'login@example.com',
            'password' => bcrypt('secret123'),
            'role' => 'customer',
        ]);

        $response = $this->post('/login', [
            'email' => 'login@example.com',
            'password' => 'secret123',
        ]);

        $response->assertRedirect('/cars');
        $this->assertAuthenticatedAs($user);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function admin_is_redirected_to_admin_dashboard_upon_login()
    {
        $admin = User::create([
            'name' => 'Admin Boss',
            'email' => 'adminboss@example.com',
            'password' => bcrypt('adminpass'),
            'role' => 'admin',
        ]);

        $response = $this->post('/login', [
            'email' => 'adminboss@example.com',
            'password' => 'adminpass',
        ]);

        $response->assertRedirect('/admin/dashboard');
        $this->assertAuthenticatedAs($admin);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function user_cannot_login_with_wrong_password()
    {
        User::create([
            'name' => 'Test User',
            'email' => 'user@example.com',
            'password' => bcrypt('secret123'),
        ]);

        $response = $this->post('/login', [
            'email' => 'user@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors();
        $this->assertGuest();
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function authenticated_user_can_logout()
    {
        $user = User::create([
            'name' => 'Logout User',
            'email' => 'logout@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->actingAs($user)->post('/logout');
        $response->assertRedirect('/');
        $this->assertGuest();
    }
}
