<?php

namespace App\Interfaces;

use App\Models\Permissions\Role;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

interface RoleRepositoryInterface
{
    public function roleAndPermissionsList();
    public function roleList(Request $request): LengthAwarePaginator;
    public function roleStore(array $data): void;
    public function roleUpdate(Role $role, array $data): void;
    public function roleDelete(Role $role): void;
}
