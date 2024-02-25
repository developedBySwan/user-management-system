<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\UserRegisterRequest;
use App\Interfaces\AuthRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    private AuthRepositoryInterface $authRepository;

    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function login(LoginRequest $loginRequest): JsonResponse
    {
        $adminUser = $this->authRepository->login($loginRequest->only('email','password'));

        abort_if(is_null($adminUser),422,"Invalid Credentials");

        return response()->json([
            'data' => [
                'user' => $adminUser,
                'token' => $adminUser->createToken('user-management')->plainTextToken,
            ],
        ]);
    }

    /**
     * User Registration api add
     * 
     * @param \App\Http\Requests\Auth\UserRegisterRequest $request
     * @return JsonResponse|mixed
     */
    public function register(UserRegisterRequest $request)
    {
        $this->authRepository->register($request->validated());

        return response()->json([
            'message' => "User Create Successfully"
        ]);
    }


    public function logout()
    {
        Auth::user()->tokens()->delete();

        return response()->json([
            'message' => 'Successfully Logout',
        ]);
    }
}
