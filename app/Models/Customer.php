<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Traits\BelongsToTenant;

class Customer extends Model
{
    use HasFactory;
    use BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'name',
        'document_type',
        'document_number',
        'email',
        'phone',
        'company',
        'position',
        'status',
        'address',
        'notes',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function leads()
    {
        return $this->hasMany(Lead::class);
    }

    public function scopeForUser($query, $user)
    {
        if ($user->hasRole('super-admin')) {
            return $query;
        } elseif ($user->hasRole('admin')) {
            $query->where('tenant_id', $user->current_tenant_id);
        } elseif ($user->hasRole('seller')) {
            $query->where('tenant_id', $user->current_tenant_id)
                ->whereHas('leads', fn($q) => $q->where('assigned_to', $user->id));
        } else {
            $query->whereRaw('1 = 0');
        }

        return $query;
    }
}
