<?php

namespace Tests\Feature;

use App\Models\CustomerData;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CustomerDataTest extends TestCase
{
    use RefreshDatabase;

    public function test_requested_customer_data_is_retrieved_for_viewing()
    {
        $user = User::factory()->create();
        $customer = CustomerData::factory()->create();

        // required as factory cannot generate storage url without breaking tests
        $customer->avatar = Storage::url($customer->avatar);

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

        // set ['avatar' => ''] to avoid breaking tests, functionally simulating an update without changing avatar
        $updatedCustomer = array_merge($customer->toArray(), ['name' => 'Jane Doe'], ['avatar' => '']);

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

    public function test_new_customer_data_view_with_placeholder_values()
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get(route('customer.create'));

        $response->assertOk();

        $response->assertInertia(
            fn($page) => $page
                ->component('Customer')
                ->has('customer')
                ->where('customer', [
                    'name' => '',
                    'email' => '',
                    'phone' => '',
                    'house_number' => '',
                    'address_1' => '',
                    'address_2' => null,
                    'postcode' => '',
                    'city' => '',
                    'state' => '',
                    'country' => '',
                    'rating' => 'Bronze',
                    'rating_manual' => false,
                    'avatar' => Storage::url('images/Profile_avatar_placeholder.png'),
                ])
        );
    }

    public function test_create_new_customer_data()
    {
        $user = User::factory()->create();
        $customer = CustomerData::factory()->make();

        $customerData = $customer->toArray();
        // required as factory cannot generate storage url without breaking tests
        // this functionally replicates creating a new customer without adding avatar in frontend
        $customerData['avatar'] = '';

        unset($customerData['id']);

        $response = $this
            ->actingAs($user)
            ->post(route('customer.store'), $customerData);

        // see above comment for why this is necessary
        $customerData['avatar'] = 'images/Profile_avatar_placeholder.png';

        $this->assertDatabaseHas('customer_data', Arr::except($customerData, ['id']));

        $savedCustomer = CustomerData::where($customerData)->first();

        $response->assertStatus(302);
        $response->assertRedirect(route('customer.show', ['id' => $savedCustomer->id]));
    }

    public function test_delete_customer_data_record()
    {
        $user = User::factory()->create();
        $customer = CustomerData::factory()->create();

        $this->assertDatabaseHas('customer_data', $customer->toArray());

        $response = $this
            ->actingAs($user)
            ->delete(route('customer.destroy', ['id' => $customer->id]));

        $this->assertDatabaseMissing('customer_data', $customer->toArray());

        $response->assertStatus(302);
        $response->assertRedirect(route('dashboard'));
    }
}
