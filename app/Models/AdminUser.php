<?php

namespace App\Models;

use App\Models\Permissions\Role;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdminUser extends BaseModel
{
    public $fillables = [
        'name',
        'username',
        'role_id',
        'phone',
        'email',
        'address',
        'password',
        'gender',
        'is_active'
    ];

    /**
     * relationship 
     */
    public function Role(): BelongsTo
    {
        return $this->belongsTo(Role::class,'role_id');
    }
}
