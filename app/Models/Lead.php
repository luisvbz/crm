<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\LeadStatus;
use App\Models\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['tenant_id','customer_id','assigned_to','name','email','phone','company','estimated_value','source','status','next_follow_up','notes'])]
class Lead extends Model
{

    use BelongsToTenant;

    protected $casts = [
        'status' => LeadStatus::class,
        'estimated_value' => 'decimal:2',
        'next_follow_up' => 'date',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function scopeFilter($query, array $filters)
    {
        return $query->when($filters['status'] ?? null, function ($q) use ($filters) {
            $q->where('status', $filters['status']);
        })->when($filters['assigned_to'] ?? null, function ($q) use ($filters) {
            $q->where('assigned_to', $filters['assigned_to']);
        })->when($filters['search'] ?? null, function ($q) use ($filters) {
            $q->where(function ($query) use ($filters) {
                $query->where('name', 'like', "%{$filters['search']}%")
                    ->orWhere('email', 'like', "%{$filters['search']}%")
                    ->orWhere('phone', 'like', "%{$filters['search']}%")
                    ->orWhere('company', 'like', "%{$filters['search']}%");
            });
        });
    }

    public function scopeForUser(Builder $query, User $user): Builder
    {
        return match(true) {
            $user->hasRole('super-admin') => $query,
            $user->hasRole('admin')       => $query->where('tenant_id', $user->current_tenant_id),
            $user->hasRole('seller')      => $query->where('tenant_id', $user->current_tenant_id)
                                                ->where('assigned_to', $user->id),
            default                       => $query->whereRaw('1 = 0'),
        };
}
}
