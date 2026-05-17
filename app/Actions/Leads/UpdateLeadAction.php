<?php

namespace App\Actions\Leads;

use App\Models\Lead;

class UpdateLeadAction
{
    public function execute(Lead $lead, array $data): Lead
    {
        $lead->update($data);
        return $lead;
    }
}
