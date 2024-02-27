<?php

namespace App\Repositories;

use App\Interfaces\AdminUserRepositoryInterface;
use App\Models\AdminUser;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class AdminUserRepository implements AdminUserRepositoryInterface
{
    public AdminUser $query;

    public function __construct(AdminUser $adminUser)
    {
        $this->query = $adminUser;
    }

    /**
     * Admin User List with pagination
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function adminUserList(Request $request): LengthAwarePaginator
    {
        return $this->query
            ->with('role')
            ->when($request->filled('name'), function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->input('name') . '%');
            })
            ->when($request->filled('phone'), fn ($query) => $query->where('phone', 'LIKE', '%'.$request->input('phone').'%'))
            ->when($request->filled('email'), fn ($query) => $query->where('email', 'LIKE', '%'.$request->input('email').'%'))
            ->when($request->filled('gender'), fn ($query) => $query->where('gender', $request->input('email')))
            ->when($request->filled('is_active'), fn ($query) => $query->where('is_active', $request->boolean('is_active')))
            ->paginate(20);
    }

    /**
     * Admin User Detail
     * @param string $adminUserId
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function adminUserDetail(string $adminUserId)
    {
        return $this->query->with('role')->findOrFail($adminUserId);
    }

    /**
     * Edit Logic for admin user
     *
     * @param \App\Models\AdminUser $adminUser
     * @param array $data
     * @return void
     */
    public function adminUserEdit(AdminUser $adminUser, array $data): void
    {
        $adminUser->update($data);
    }

    /**
     * Admin User Delete Logic add
     * @param \App\Models\AdminUser $adminUser
     * @return void
     */
    public function adminUserDelete(AdminUser $adminUser): void
    {
        $adminUser->delete();
    }
}
