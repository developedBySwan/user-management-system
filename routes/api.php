<?php

use App\Http\Controllers\Api\AdminUserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Role\RoleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('/login', 'login');

        Route::middleware('auth:sanctum')->prefix('user')->group(function () {
            Route::post('/register', 'register');
            Route::post('/logout', 'logout');
        });
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::controller(AdminUserController::class)->prefix("/admin-user")->group(function () {
            Route::get('/', 'userList')->middleware('permission:user,view');
            Route::get('/detail/{adminUserId}', 'userDetail')->middleware('permission:user,view');
            Route::put('/update/{adminUser}', 'userUpdate')->middleware('permission:user,update');
            Route::delete('/delete/{adminUser}', 'userDelete')->middleware('permission:user,delete');
        });

        Route::controller(RoleController::class)->prefix('/role')->group(function () {
            Route::get('/permissions', 'roleAndPermissionsList')->middleware('permission:role,view');
            Route::get('/', 'roleList')->middleware('permission:role,view');
            Route::post('/store', 'roleStore')->middleware('permission:role,create');
            Route::put('/update/{role}', 'roleUpdate')->middleware('permission:role,update');
            Route::delete('/delete/{role}', 'roleDelete')->middleware('permission:role,delete');
        });
    });

});
