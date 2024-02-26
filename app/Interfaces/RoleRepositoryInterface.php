<?php

namespace App\Interfaces;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;

interface RoleRepositoryInterface
{
    public function roleAndPermissionsList();
    public function roleList(Request $request): LengthAwarePaginator;
    public function roleStore(array $data);
}