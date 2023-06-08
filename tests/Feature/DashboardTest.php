<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Providers\RouteServiceProvider;

class DashboardTest extends TestCase
{

    // readon https://vegibit.com/how-to-create-a-feature-test-in-laravel/
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_user_dashboard_rendered(): void
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)
                         ->get('/dashboard');

        $response->assertStatus(200);
    }

    public function test_user_is_admin_dashboard_rendered(): void
    {
        $user = User::factory()->create([
            'is_admin' => 1,
        ]);
                
        $response = $this->actingAs($user)
                         ->get('/admin/dashboard');
        $response->assertStatus(200);
    }

    public function test_user_is_not_admin_redirect(): void
    {
        $user = User::factory()->create([
            'is_admin' => 0,
        ]);
                
        $response = $this->actingAs($user)
                         ->get('/admin/dashboard');
        
        $response->assertStatus(302);
    }
}
