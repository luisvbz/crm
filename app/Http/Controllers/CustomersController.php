<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Inertia\Inertia;

class CustomersController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $customers = Customer::forUser($user)->with(['leads' => fn($q) => $q->select('id', 'customer_id', 'status', 'estimated_value', 'converted_at')])->get();

        return Inertia::render('Customers/Index', [
            'customers' => $customers
        ]);
    }
}
