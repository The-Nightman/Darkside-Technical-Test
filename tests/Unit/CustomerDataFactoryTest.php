<?php

namespace Tests\Unit;

use App\Models\CustomerData;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class CustomerDataFactoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that the CustomerData factory creates valid CustomerData instances.
     */
    public function test_customer_data_factory_creates_valid_instances(): void
    {
        $customerData = CustomerData::factory()->create();

        $this->assertInstanceOf(CustomerData::class, $customerData);

        // Check that the customer data has the expected required attributes
        foreach (
            ['name', 'email', 'phone', 'house_number', 'address_1', 'postcode', 'city', 'state', 'country', 'rating']
            as $attribute
        ) {
            $this->assertNotEmpty($customerData->$attribute);
        }

        $this->assertIsBool($customerData->rating_manual);

        $this->assertTrue(Schema::hasColumn('customer_data', 'address_2'));
    }
}
