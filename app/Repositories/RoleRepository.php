<?php
namespace App\Repositories;

use App\Interfaces\RoleRepositoryInterface;
use App\Models\Permissions\Permission;
use App\Models\Permissions\Role;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
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
        $permissions = Permission::query()
                        // ->select(DB::raw('MIN(id) AS id'),DB::raw('MAX(name) AS name'),'feature_id')
                        ->with('feature')
                        // ->groupBy('feature_id')
                        ->count();

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
                ->when($request->filled('name'), fn($query) => $query->where('name','LIKE','%'.$query->input('name').'%'))
                ->orderBy('name')
                ->paginate(20);
    }

    public function roleStore(array $data)
    {
        $permissions = $data['permissions'];

        foreach($permissions as $feature => $permission) {
            dd($permission,$feature);
        }

        try {
            DB::beginTransaction();

            $role = Role::create([
                'name' => $data['name']
            ]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 500
            ]);
        }


    }
}