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

    public function test_customer_data_can_be_updated()
    {
        $user = User::factory()->create();
        $customer = CustomerData::factory()->create();

        $updatedCustomer = array_merge($customer->toArray(), ['name' => 'Jane Doe']);

        $response = $this
            ->actingAs($user)
            ->put(route('customer.update', ['id' => $customer->id]), $updatedCustomer);

        $response->assertStatus(302);
        $response->assertRedirect(route('customer.show', ['id' => $customer->id]));

        $this->assertDatabaseHas('customer_data', [
            'id' => $customer['id'],
            'name' => $updatedCustomer['name']
        ]);
    }
}
