<?php

namespace App\Http\Controllers;

use App\Models\CustomerData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class DashboardController extends Controller
{

    // Define validation allowed filters as controller variables for maintainability and performance
    protected $allowedSortBy = ['name', 'rating'];
    protected $allowedOrderBy = ['asc', 'desc'];
    protected $allowedRatings = ['bronze', 'silver', 'gold', 'platinum'];

    public function index()
    {

        $sortBy = request('sortBy', 'name');
        $orderBy = request('order', 'asc');
        $ratingFilter = request('rating', null);
        $search = request('search', null);


        // Validate filters, PDO doesnt protect against SQL injection in the case of column names in query
        $validator = Validator::make([
            'sortBy' => $sortBy,
            'order' => $orderBy,
            'rating' => $ratingFilter,
            'search' => $search,
        ], [
            'sortBy' => ['required', 'in:' . implode(',', $this->allowedSortBy)],
            'order' => ['required', 'in:' . implode(',', $this->allowedOrderBy)],
            'rating' => ['nullable', 'in:' . implode(',', $this->allowedRatings)],
            'search' => ['nullable', 'string', 'max:70'],
        ]);

        if ($validator->fails()) {
            return redirect('/dashboard')->withErrors($validator);
        }

        // Set the order of ratings, anything added in future needs to
        // be specified or else it will return in the else clause
        $sortBy === 'rating' ?
            $orderByRaw = "CASE
            WHEN rating = 'bronze' THEN 1
            WHEN rating = 'silver' THEN 2
            WHEN rating = 'gold' THEN 3
            WHEN rating = 'platinum' THEN 4
            ELSE 5
        END $orderBy" : $orderByRaw = "$sortBy $orderBy";

        // Start query with only customer details needed for list in frontend
        $query = CustomerData::select([
            'id',
            'name',
            'email',
            'phone',
            'rating',
            'avatar',
        ]);

        // check if rating filter is set before adding to query
        if ($ratingFilter) {
            $query->where('rating', $ratingFilter);
        }

        // check if name search is set before adding to query
        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        $customers = $query->orderByRaw($orderByRaw)->get();

        $customers->transform(function ($customer) {
            $customer->avatar = Storage::url($customer->avatar);
            return $customer;
        });

        return Inertia::render('Dashboard', [
            'customers' => $customers, // Pass customer details to the view
        ]);
    }
}
