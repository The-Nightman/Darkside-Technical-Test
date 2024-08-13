<?php

namespace Tests\Feature;

use App\Models\CustomerData;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that the dashboard page is displayed.
     */
    public function test_dashboard_page_is_rendered(): void
    {
        $user = User::factory()->create();

        // spoof an authenticated user
        $response = $this
            ->actingAs($user)
            ->get('/dashboard');

        $response->assertOk();
    }

    /**
     * Test that customer data is sent with the dashboard.
     */
    public function test_customer_data_is_sent_with_dashboard(): void
    {
        $user = User::factory()->create();
        $customers = CustomerData::factory(10)->create();

        // spoof an authenticated user
        $response = $this
            ->actingAs($user)
            ->get('/dashboard');

        $response->assertOk();

        // Check that the customers are sent to the view and match db contents
        $response->assertInertia(
            fn($page) => $page
                ->component('Dashboard')
                ->has('customers', 10)
                ->where('customers', $customers->toArray())
        );
    }
}
