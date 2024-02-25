<?php

namespace App\Interfaces;

use App\Http\Requests\Auth\UserRegisterRequest;
use App\Models\AdminUser;

interface AuthRepositoryInterface
{
    public function login(array $loginCredentials);
    public function register(array $user): AdminUser;
    // public function logout();
}