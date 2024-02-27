<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminUser\AdminUserEditRequest;
use App\Http\Resources\AdminUser\AdminUserDetailResource;
use App\Http\Resources\AdminUser\AdminUserListResource;
use App\Interfaces\AdminUserRepositoryInterface;
use App\Models\AdminUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AdminUserController extends Controller
{
    private AdminUserRepositoryInterface $adminUserRepositoryInterface;

    public function __construct(AdminUserRepositoryInterface $adminUserRepositoryInterface)
    {
        $this->adminUserRepositoryInterface = $adminUserRepositoryInterface;
    }

    /**
     * Admin User list endpoint
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function userList(Request $request): AnonymousResourceCollection
    {
        return AdminUserListResource::collection($this->adminUserRepositoryInterface->adminUserList($request));
    }

    /**
     * Admin User Detail API
     *
     * @param string $adminUserId
     *
     * @return \App\Http\Resources\AdminUser\AdminUserDetailResource
     */
    public function userDetail(string $adminUserId): AdminUserDetailResource
    {
        return AdminUserDetailResource::make($this->adminUserRepositoryInterface->adminUserDetail($adminUserId));
    }

    /**
     * Update Api for Admin User
     * @param \App\Models\AdminUser $adminUser
     * @param \App\Http\Requests\AdminUser\AdminUserEditRequest $adminUserEditRequest
     * @return JsonResponse
     */
    public function userUpdate(AdminUser $adminUser, AdminUserEditRequest $adminUserEditRequest): JsonResponse
    {
        $this->adminUserRepositoryInterface->adminUserEdit($adminUser, $adminUserEditRequest->validated());

        return response()->json([
            'message' => "Updated Successfully",
        ]);
    }


    /**
     * User Delete Api
     * @param \App\Models\AdminUser $adminUser
     * @return \Illuminate\Http\JsonResponse
     */
    public function userDelete(AdminUser $adminUser): JsonResponse
    {
        $this->adminUserRepositoryInterface->adminUserDelete($adminUser);

        return response()->json([
            'message' => "Successfully Deleted",
        ]);
    }

}
