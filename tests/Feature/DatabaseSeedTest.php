<?php

namespace Tests\Feature;

use App\Models\CustomerData;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class DatabaseSeedTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_customer_data_is_seeded_to_database(): void
    {
        // Run seeder
        $this->artisan('db:seed', ['--class' => 'DatabaseSeeder']);

        // Check that the customer_data table has the expected number of records
        $this->assertCount(10, CustomerData::all());

        // Check that the customer_data table has the expected attributes
        $customerData = CustomerData::first();
        $this->assertNotNull($customerData);
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
