<?php

namespace App\Models\Permissions;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends BaseModel
{
    public $fillable = [
        'name',
    ];

    /**
     * Relationship
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_permissions');
    }
}
