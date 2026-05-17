<?php

namespace App\Policies;

use App\Models\Lead;
use App\Models\User;

class LeadPolicy
{
    
    public function before(User $user, string $ability): ?bool
    {
        if ($user->hasRole('super-admin')) {
            return true;
        }

        return null;
    }

    public function viewAny(User $user): bool
    {
        return $user->hasRole(['admin', 'seller']);
    }

    public function view(User $user, Lead $lead): bool
    {
        return $this->checkAccess($user, $lead);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['admin', 'seller']);
    }

    public function update(User $user, Lead $lead): bool
    {
        return $this->checkAccess($user, $lead);
    }

    public function delete(User $user, Lead $lead): bool
    {
        return $this->checkAccess($user, $lead);
    }

    private function checkAccess(User $user, Lead $lead): bool
    {
        if ($user->hasRole('admin')) {
            return $lead->tenant_id === $user->current_tenant_id;
        }

        if ($user->hasRole('seller')) {
            return $lead->assigned_to === $user->id;
        }

        return false;
    }
}
