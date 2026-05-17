<?php

namespace App\Actions\Leads;

use App\Models\Lead;

class UpdateLeadStatusAction
{
    public function execute(Lead $lead, string $newStatus): Lead
    {
        $lead->update(['status' => $newStatus]);
        return $lead;
    }
}
