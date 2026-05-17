<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Actions\Leads\CreateLeadAction;
use App\Actions\Leads\UpdateLeadAction;
use App\Actions\Leads\UpdateLeadStatusAction;
use App\Enums\LeadStatus;

use App\Http\Requests\StoreLeadRequest;
use App\Http\Requests\UpdateLeadRequest;
use App\Http\Requests\UpdateLeadStatusRequest;

class LeadsController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $tenantId = $user->current_tenant_id;
        
        $query = Lead::query();

        if ($user->hasRole('super-admin')) {
            // Acceso sin restricciones globales
        } elseif ($user->hasRole('admin')) {
            $query->where('tenant_id', $tenantId);
        } elseif ($user->hasRole('seller')) {
            $query->where('tenant_id', $tenantId)->where('assigned_to', $user->id);
        } else {
            $query->whereRaw('1 = 0');
        }
        
        $leads = $query->get();
        $statuses = array_column(LeadStatus::cases(), 'value');

        return Inertia::render('Leads/Index', [
            'leads' => $leads,
            'statuses' => $statuses
        ]);
    }

    public function store(StoreLeadRequest $request, CreateLeadAction $createLead)
    {
        $createLead->execute($request->validated());

        return redirect()->back();
    }

    public function update(UpdateLeadRequest $request, Lead $lead, UpdateLeadAction $updateLead)
    {
        $updateLead->execute($lead, $request->validated());

        return redirect()->back();
    }

    public function updateStatus(UpdateLeadStatusRequest $request, Lead $lead, UpdateLeadStatusAction $updateStatus)
    {
        $updateStatus->execute($lead, $request->validated()['status']);

        return redirect()->back();
    }
    
    public function destroy(Lead $lead)
    {
        $lead->delete();
        return redirect()->back();
    }
}
