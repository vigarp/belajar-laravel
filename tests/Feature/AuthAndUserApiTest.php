<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthAndUserApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Memastikan endpoint register berhasil membuat user baru dan mengembalikan token Bearer.
     */
    public function test_user_can_register_via_api(): void
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => 'secret123',
            'phone' => '081234567890',
            'address' => 'Jl. Merdeka No. 1',
            'role' => 'admin',
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'User registrasi berhasil',
                'token_type' => 'Bearer',
            ])
            ->assertJsonStructure([
                'success',
                'message',
                'data' => ['id', 'name', 'email', 'phone', 'address', 'role'],
                'access_token',
                'token_type',
            ]);

        $this->assertDatabaseHas('users', [
            'email' => 'budi@example.com',
            'phone' => '081234567890',
            'address' => 'Jl. Merdeka No. 1',
            'role' => 'admin',
        ]);
    }

    /**
     * Memastikan endpoint register mengembalikan status 422 jika validasi gagal.
     */
    public function test_register_fails_with_validation_error(): void
    {
        $response = $this->postJson('/api/register', [
            'name' => '',
            'email' => 'not-an-email',
            'password' => '123',
        ]);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
            ])
            ->assertJsonValidationErrors(['name', 'email', 'password']);
    }

    /**
     * Memastikan login API berhasil mengembalikan token dan data user lengkap.
     */
    public function test_user_can_login_via_api(): void
    {
        $user = User::factory()->create([
            'email' => 'api@example.com',
            'password' => Hash::make('password123'),
            'phone' => '089988776655',
            'address' => 'Tangerang Selatan',
            'role' => 'admin',
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'api@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Login berhasil',
                'token_type' => 'Bearer',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => 'api@example.com',
                    'phone' => '089988776655',
                    'address' => 'Tangerang Selatan',
                    'role' => 'admin',
                ],
            ])
            ->assertJsonStructure(['access_token']);
    }

    /**
     * Memastikan login API mengembalikan status 401 jika kredensial salah.
     */
    public function test_login_fails_with_invalid_credentials(): void
    {
        User::factory()->create([
            'email' => 'api@example.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'api@example.com',
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'success' => false,
                'message' => 'Email atau password salah',
            ]);
    }

    /**
     * Memastikan endpoint users dan logout terlindungi oleh Sanctum.
     */
    public function test_unauthenticated_request_to_protected_endpoints_returns_401(): void
    {
        $this->getJson('/api/users')->assertStatus(401);
        $this->postJson('/api/logout')->assertStatus(401);
    }

    /**
     * Memastikan CRUD users dan logout API berjalan menggunakan token Sanctum.
     */
    public function test_authenticated_user_can_crud_users_and_logout(): void
    {
        $authUser = User::factory()->create([
            'role' => 'admin',
        ]);
        $token = $authUser->createToken('auth_token')->plainTextToken;

        $headers = ['Authorization' => 'Bearer '.$token];

        // List users
        $this->getJson('/api/users', $headers)
            ->assertStatus(200)
            ->assertJson(['success' => true])
            ->assertJsonCount(1, 'data');

        // Create user
        $createResponse = $this->postJson('/api/users', [
            'name' => 'Siti Aminah',
            'email' => 'siti@example.com',
            'password' => 'password123',
            'phone' => '081122334455',
            'address' => 'Jakarta',
            'role' => 'user',
        ], $headers);

        $createResponse->assertStatus(201)
            ->assertJson([
                'success' => true,
                'data' => [
                    'name' => 'Siti Aminah',
                    'email' => 'siti@example.com',
                    'phone' => '081122334455',
                    'address' => 'Jakarta',
                    'role' => 'user',
                ],
            ]);

        $createdUserId = $createResponse->json('data.id');

        // Show user
        $this->getJson('/api/users/'.$createdUserId, $headers)
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => ['id' => $createdUserId],
            ]);

        // Update user
        $this->putJson('/api/users/'.$createdUserId, [
            'name' => 'Siti Updated',
            'phone' => '085566778899',
            'address' => 'Bandung',
            'role' => 'editor',
        ], $headers)
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'name' => 'Siti Updated',
                    'phone' => '085566778899',
                    'address' => 'Bandung',
                    'role' => 'editor',
                ],
            ]);

        // Delete user
        $this->deleteJson('/api/users/'.$createdUserId, [], $headers)
            ->assertStatus(200)
            ->assertJson(['success' => true]);

        $this->assertDatabaseMissing('users', ['id' => $createdUserId]);

        // Logout API
        $this->postJson('/api/logout', [], $headers)
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Logout berhasil',
            ]);

        $this->assertDatabaseCount('personal_access_tokens', 0);
    }

    /**
     * Memastikan login dan logout admin web tetap berjalan normal.
     */
    public function test_web_admin_login_and_logout_still_work(): void
    {
        $admin = User::factory()->create([
            'email' => 'webadmin@example.com',
            'password' => Hash::make('password123'),
        ]);

        $this->get('/admin/login')->assertStatus(200);

        $this->post('/admin/login', [
            'email' => 'webadmin@example.com',
            'password' => 'password123',
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticatedAs($admin);

        $this->post('/admin/logout')->assertRedirect(route('admin.login'));
        $this->assertGuest();
    }
}
