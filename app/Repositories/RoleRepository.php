<?php

namespace App\Repositories;

use App\Interfaces\RoleRepositoryInterface;
use App\Models\Permissions\Feature;
use App\Models\Permissions\Permission;
use App\Models\Permissions\Role;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class RoleRepository implements RoleRepositoryInterface
{
    private Role $query;

    public function __construct(Role $role)
    {
        $this->query = $role;
    }

    /**
     * Role And Permission List
     *
     */
    public function roleAndPermissionsList()
    {
        $permissions = Feature::query()
                ->with('permissions')
                ->get();

        return $permissions;
    }

    /**
     * Role list
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function roleList(Request $request): LengthAwarePaginator
    {
        return $this->query
                ->when($request->filled('name'), fn ($query) => $query->where('name', 'LIKE', '%'.$query->input('name').'%'))
                ->orderBy('name')
                ->paginate(20);
    }

    /**
     * Role Store
     * @param array $data
     * @return void
     */
    public function roleStore(array $data): void
    {
        DB::beginTransaction();

        try {

            $role = Role::create([
                'name' => $data['name']
            ]);

            $role->permissions()->attach($data['permissions']);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            abort(500, $e->getMessage());
        }
    }

    /**
     * Role Update
     * @param \App\Models\Permissions\Role $role
     * @param array $data
     * @return void
     */
    public function roleUpdate(Role $role, array $data): void
    {
        DB::beginTransaction();

        try {
            $role->update([
                'name' => $data['name'],
            ]);

            $role->refresh()->permissions()->sync($data['permissions']);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            abort(500, $e->getMessage());
        }
    }

    /**
     * Role Delete
     * @param \App\Models\Permissions\Role $role
     * @return void
     */
    public function roleDelete(Role $role): void
    {
        DB::beginTransaction();

        try {
            $role->permissions()->detach();
            $role->delete();

            DB::commit();
        } catch (Exception $e) {
            abort(500, $e->getMessage());
        }
    }
}
