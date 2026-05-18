<?php

namespace App\Actions\Leads;

use App\Models\Lead;
use App\Models\Customer;

class ConvertLeadToCustomerAction
{
    public function execute(Lead $lead): Customer
    {
        $customer = Customer::create([
            'tenant_id' => $lead->tenant_id,
            'name'      => $lead->name,
            'email'     => $lead->email,
            'phone'     => $lead->phone,
            'company'   => $lead->company,
            'notes'     => $lead->notes,
            'status'    => 'active',
        ]);

        $lead->update([
            'customer_id'  => $customer->id,
            'converted_at' => now(),
        ]);

        return $customer;
    }
}
