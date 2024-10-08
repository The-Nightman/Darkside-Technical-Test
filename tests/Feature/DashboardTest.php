<?php

namespace Tests\Feature;

use App\Models\CustomerData;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
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

        // map the customers to the expected columns used by dashboard
        $expectedCustomers = $customers->sortBy('name')
            ->map(function ($customer) {
                $data = $customer->only([
                    'id',
                    'name',
                    'email',
                    'phone',
                    'rating',
                    'avatar',
                ]);
                $data['avatar'] = Storage::url($data['avatar']);
                return $data;
            })->values()->toArray();

        // spoof an authenticated user
        $response = $this
            ->actingAs($user)
            ->get('/dashboard');

        // Check that the customers are sent to the view and match db contents
        $response->assertInertia(
            fn($page) => $page
                ->component('Dashboard')
                ->has('customers.data', 10)
                ->where('customers.data', $expectedCustomers)
        );
    }

    /**
     * Test that (sortBy name, order desc) query params function.
     */
    public function test_query_params_sortBy_name_order_desc(): void
    {
        $user = User::factory()->create();
        $customers = CustomerData::factory(10)->create();

        $expectedCustomers = $customers->sortByDesc('name')
            ->map(function ($customer) {
                $data = $customer->only([
                    'id',
                    'name',
                    'email',
                    'phone',
                    'rating',
                    'avatar',
                ]);
                $data['avatar'] = Storage::url($data['avatar']);
                return $data;
            })->values()->toArray();

        $response = $this
            ->actingAs($user)
            ->get('/dashboard?sortBy=name&order=desc');

        $response->assertInertia(
            fn($page) => $page
                ->component('Dashboard')
                ->has('customers.data', 10)
                ->where('customers.data', $expectedCustomers)
        );
    }

    /**
     * Test that rating filter query param functions.
     */
    public function test_query_params_rating_filter(): void
    {
        $user = User::factory()->create();
        $customers = CustomerData::factory(10)->create();

        $expectedCustomers = $customers->filter(function ($customer) {
            return $customer->rating == 'Gold';
        })->sortBy('name')
            ->map(function ($customer) {
                $data = $customer->only([
                    'id',
                    'name',
                    'email',
                    'phone',
                    'rating',
                    'avatar',
                ]);
                $data['avatar'] = Storage::url($data['avatar']);
                return $data;
            })->values()->toArray();

        $response = $this
            ->actingAs($user)
            ->get('/dashboard?rating=gold');

        $response->assertInertia(
            fn($page) => $page
                ->component('Dashboard')
                ->has('customers.data', count($expectedCustomers))
                ->where('customers.data', $expectedCustomers)
        );
    }

    /**
     * Test that the customer name search query functions.
     */
    public function test_customer_name_search_functions(): void
    {
        $user = User::factory()->create();
        $customers = CustomerData::factory(9)->create();

        // the sacrificial lamb
        $johnDoe = CustomerData::factory()->create(['name' => 'John Doe']);
        // to the slaughter
        $customers->push($johnDoe);

        $expectedCustomers = $customers->filter(function ($customer) {
            return stripos($customer->name, 'john') !== false;
        })->sortBy('name')
            ->map(function ($customer) {
                $data = $customer->only([
                    'id',
                    'name',
                    'email',
                    'phone',
                    'rating',
                    'avatar',
                ]);
                $data['avatar'] = Storage::url($data['avatar']);
                return $data;
            })->values()->toArray();

        $response = $this
            ->actingAs($user)
            ->get('/dashboard?search=john');

        $response->assertInertia(
            fn($page) => $page
                ->component('Dashboard')
                ->has('customers.data', count($expectedCustomers))
                ->where('customers.data', $expectedCustomers)
        );
    }
}
