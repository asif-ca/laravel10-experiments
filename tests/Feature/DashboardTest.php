<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Providers\RouteServiceProvider;

class DashboardTest extends TestCase
{

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

    
}
