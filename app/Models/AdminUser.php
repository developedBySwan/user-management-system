<?php

namespace App\Models;

use App\Enums\Gender;
use App\Models\Permissions\Role;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class AdminUser extends Authenticatable implements FilamentUser
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

    protected $casts = [
        'password' => 'hashed',
        'gender' => Gender::class,
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    /**
     * relationship
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
