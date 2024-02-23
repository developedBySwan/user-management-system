<?php

namespace App\Models\Permissions;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends BaseModel
{
    public $fillables = [
        'name',
        'feature_id'
    ];

    /**
     * relationship   
     */
    public function feature(): BelongsTo
    {
        return $this->belongsTo(Feature::class, 'feature_id');
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class,"role_permissions");
    }
}
