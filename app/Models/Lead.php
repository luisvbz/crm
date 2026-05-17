<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\LeadStatus;
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
}
