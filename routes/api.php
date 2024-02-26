<?php

use App\Http\Controllers\Api\AdminUserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
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

Route::prefix('v1')->group(function() {
    Route::controller(AuthController::class)->group(function () {
        Route::post('/login', 'login');

        Route::middleware('auth:sanctum')->prefix('user')->group(function () {
            Route::post('/register', 'register');
            Route::post('/logout', 'logout');
        });
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::controller(AdminUserController::class)->prefix("/admin-user")->group(function () {
            Route::get('/', 'userList');
            Route::get('/detail/{adminUserId}', 'userDetail');
            Route::put('/update/{adminUser}', 'userUpdate');
            Route::delete('/delete/{adminUser}', 'userDelete');
        });
    });

});
