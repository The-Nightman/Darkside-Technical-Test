<?php

namespace Tests\Feature;

use App\Models\CustomerData;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerDataTest extends TestCase
{
    use RefreshDatabase;

    public function test_requested_customer_data_is_retrieved_for_viewing()
    {
        $user = User::factory()->create();
        $customer = CustomerData::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get(route('customer.show', ['id' => $customer->id]));

        $response->assertOk();

        $response->assertInertia(
            fn($page) => $page
                ->component('Customer')
                ->has('customer')
                ->where('customer', $customer)
        );
    }
}
