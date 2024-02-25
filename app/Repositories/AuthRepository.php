<?php

namespace App\Repositories;

use App\Http\Requests\Auth\UserRegisterRequest;
use App\Interfaces\AuthRepositoryInterface;
use App\Models\AdminUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthRepository implements AuthRepositoryInterface
{
    /**
     * Admin User Login
     * 
     * @param array $loginCredentials
     * 
     * @return object|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|null
     */
    public function login(array $loginCredentials)
    {
        $adminUser = AdminUser::query()
            ->where('email', $loginCredentials['email'])
            ->first();

        if($adminUser && Hash::check($loginCredentials['password'],$adminUser->password)) {
            return $adminUser;
        }

        return null;
    }

    public function register(array $user): AdminUser
    {
        return AdminUser::create($user);
    }
}