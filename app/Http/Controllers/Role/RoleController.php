<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\RoleStoreRequest;
use App\Http\Resources\Role\RoleAndPermissionResponse;
use App\Http\Resources\Role\RoleListResponse;
use App\Interfaces\RoleRepositoryInterface;
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
}
