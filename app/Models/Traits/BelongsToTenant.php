<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait BelongsToTenant
{
    protected static function bootBelongsToTenant()
    {
        static::creating(function ($model) {
            if (auth()->check()) {
                $model->tenant_id = auth()->user()->current_tenant_id;
            }
        });

        static::addGlobalScope('tenant', function (Builder $builder) {
            if (auth()->check()) {
                $user = auth()->user();
                if (!$user->hasRole('super-admin') && $user->current_tenant_id) {
                    $builder->where('tenant_id', $user->current_tenant_id);
                }
            }
        });
    }
}