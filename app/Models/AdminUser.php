<?php

namespace App\Models;

use App\Models\Permissions\Role;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class AdminUser extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasUlids;

    public $fillable = [
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
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
