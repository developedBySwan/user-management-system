<?php

namespace App\Providers;

use App\Interfaces\AdminUserRepositoryInterface;
use App\Interfaces\AuthRepositoryInterface;
use App\Interfaces\RoleRepositoryInterface;
use App\Repositories\AdminUserRepository;
use App\Repositories\AuthRepository;
use App\Repositories\RoleRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
        $this->app->bind(AdminUserRepositoryInterface::class, AdminUserRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
