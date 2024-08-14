<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerDataCreateRequest;
use App\Http\Requests\CustomerDataUpdateRequest;
use App\Models\CustomerData;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CustomerController extends Controller
{
    public function create()
    {
        // Create a new customer with empty values
        $newCustomer = new CustomerData([
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
            'rating' => '',
            'rating_manual' => false,
        ]);

        return Inertia::render('Customer', ['customer' => $newCustomer]);
    }

    public function store(CustomerDataCreateRequest $request)
    {
        $customer = CustomerData::create($request->validated());
        return redirect()->route('customer.show', ['id' => $customer->id]);
    }

    public function show(Request $request)
    {
        // cast request id to key-value pair array
        // without this validation will fail and customer cannot be retrieved even without validation
        // i do not know why but it will just redirect back to dashboard
        $request->merge(['id' => $request->route('id')]);

        // Validate request
        $request->validate([
            'id' => [
                'required',
                'integer',
                'exists:customer_data,id'
            ]
        ]);

        // Fetch customer details by id
        $customer = CustomerData::findOrFail($request->id);
        return Inertia::render('Customer', [
            'customer' => $customer,
        ]);
    }

    public function update(CustomerDataUpdateRequest $request)
    {
        $request->validate([
            'id' => [
                'required',
                'integer',
                'exists:customer_data,id'
            ]
        ]);

        $customer = CustomerData::findOrFail($request->id);

        $customer->update($request->validated());

        return redirect()->route('customer.show', ['id' => $customer->id]);
    }
}
