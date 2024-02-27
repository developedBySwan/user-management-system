<?php

namespace App\Models\Permissions;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Feature extends BaseModel
{
    public $fillable = [
        'name'
    ];

    public function permissions(): HasMany
    {
        return $this->hasMany(Permission::class, 'feature_id', 'id');
    }
}
