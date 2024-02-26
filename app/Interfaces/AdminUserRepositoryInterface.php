<?php
namespace App\Interfaces;

use App\Models\AdminUser;
use Illuminate\Http\Request;

interface AdminUserRepositoryInterface
{
    public function adminUserList(Request $request);
    public function adminUserDetail(string $adminUser);
    public function adminUserEdit(AdminUser $adminUser, array $data): void;
    public function adminUserDelete(AdminUser $adminUser): void;
}