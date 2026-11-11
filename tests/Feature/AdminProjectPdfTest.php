<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminProjectPdfTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tamu / guest harus diarahkan ke halaman login saat mengakses cetak PDF.
     */
    public function test_guest_is_redirected_to_login_when_accessing_pdf(): void
    {
        $response = $this->get(route('projects.pdf'));

        $response->assertRedirect(route('admin.login'));
    }

    /**
     * Admin terotentikasi dapat mengakses dan mengunduh / streaming file PDF.
     */
    public function test_admin_can_access_projects_pdf(): void
    {
        $user = User::factory()->create();

        Project::create([
            'title' => 'Project Testing',
            'description' => 'Deskripsi testing project',
            'teknologi' => 'Laravel, MySQL',
            'image' => null,
            'status' => 'active',
        ]);

        $response = $this->actingAs($user)->get(route('projects.pdf'));

        $response->assertOk();
        $response->assertHeader('Content-Type', 'application/pdf');
    }
}
