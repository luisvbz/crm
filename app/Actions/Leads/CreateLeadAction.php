<?php

namespace App\Actions\Leads;

use App\Models\Lead;
use Illuminate\Support\Facades\Auth;

class CreateLeadAction
{
    public function execute(array $data): Lead
    {
        $user = Auth::user();
        $data['tenant_id'] = $user->current_tenant_id;
        
        // Asignación automática: Si es seller
        if (!isset($data['assigned_to']) && $user->hasRole('seller')) {
            $data['assigned_to'] = $user->id;
        }

        return Lead::create($data);
    }
}
