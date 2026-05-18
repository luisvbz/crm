<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Actions\Leads\CreateLeadAction;
use App\Actions\Leads\UpdateLeadAction;
use App\Actions\Leads\UpdateLeadStatusAction;
use App\Actions\Leads\ConvertLeadToCustomerAction;
use App\Enums\LeadStatus;

use App\Http\Requests\StoreLeadRequest;
use App\Http\Requests\UpdateLeadRequest;
use App\Http\Requests\UpdateLeadStatusRequest;

class LeadsController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $leads = Lead::forUser($user)->get();

        $statuses = collect(LeadStatus::cases())->map(fn($status) => [
            'value' => $status->value,
            'label' => $status->label(),
        ]);

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

    public function convert(Lead $lead, ConvertLeadToCustomerAction $action)
    {
        $this->authorize('update', $lead);

        if ($lead->status !== LeadStatus::WON) {
            return redirect()->back()->with('error', 'Solo se pueden convertir leads ganados.');
        }

        if ($lead->isConverted()) {
            return redirect()->back()->with('error', 'Este lead ya fue convertido.');
        }

        $action->execute($lead);

        return redirect()->back()->with('success', 'Lead convertido a cliente exitosamente.');
    }

    public function destroy(Lead $lead)
    {
        $lead->delete();
        return redirect()->back();
    }
}
