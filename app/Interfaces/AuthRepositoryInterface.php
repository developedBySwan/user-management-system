<?php

namespace App\Interfaces;

use App\Models\AdminUser;

interface AuthRepositoryInterface
{
    public function login(array $loginCredentials);
    public function register(array $user): AdminUser;
}
