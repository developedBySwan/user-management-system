<?php

namespace App\Http\Controllers\Api\Role;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\RoleStoreRequest;
use App\Http\Resources\Role\RoleAndPermissionResponse;
use App\Http\Resources\Role\RoleListResponse;
use App\Interfaces\RoleRepositoryInterface;
use App\Models\Permissions\Role;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class RoleController extends Controller
{
    protected RoleRepositoryInterface $roleRepositoryInterface;

    public function __construct(RoleRepositoryInterface $roleRepositoryInterface)
    {
        $this->roleRepositoryInterface = $roleRepositoryInterface;
    }

    /**
     * Api For Role And Permissions
     *
     * @return JsonResponse
     *
     */
    public function roleAndPermissionsList(): AnonymousResourceCollection
    {
        return RoleAndPermissionResponse::collection($this->roleRepositoryInterface->roleAndPermissionsList());
    }

    /**
     * Role List Endpoint
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function roleList(Request $request): AnonymousResourceCollection
    {
        return RoleListResponse::collection($this->roleRepositoryInterface->roleList($request));
    }

    /**
     * Role Store API
     * @return JsonResponse
     */
    public function roleStore(RoleStoreRequest $roleStoreRequest): JsonResponse
    {
        $this->roleRepositoryInterface->roleStore($roleStoreRequest->validated());

        return response()->json([
            'message' => 'successfully Created',
        ]);
    }

    /**
     * Role Update Api add
     * @param \App\Models\Permissions\Role $role
     * @param \App\Http\Requests\Role\RoleStoreRequest $roleStoreRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function roleUpdate(Role $role, RoleStoreRequest $roleStoreRequest): JsonResponse
    {
        $this->roleRepositoryInterface->roleUpdate($role, $roleStoreRequest->validated());

        return response()->json([
            'message' => "Successfully Updated"
        ]);
    }

    /**
     * Role Delete Api
     * @param \App\Models\Permissions\Role $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function roleDelete(Role $role): JsonResponse
    {
        $this->roleRepositoryInterface->roleDelete($role);

        return response()->json([
            'message' => "Successfully Deleted"
        ]);
    }
}
