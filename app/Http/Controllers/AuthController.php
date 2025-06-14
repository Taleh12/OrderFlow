<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Laravel\Sanctum\Sanctum;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{

    protected AuthService $authService;


    public function __construct(AuthService $authService)
    {
        return $this->authService = $authService;
    }

    // protected AuthService $authService;
    public function login(LoginRequest $request)
    {
        $result = $this->authService->login($request->validated());

        if ($result) {
            return response()->json($result);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function register(RegisterRequest $request)
    {
        $user = $this->authService->register($request->validated());

        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
        ]);
    }

    public function logout(Request $request)
    {
        $this->authService->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
    public function user(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            return response()->json($user);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }
    public function getUserById($id)
    {
        $user = $this->authService->getUserById($id);

        if ($user) {
            return response()->json($user);
        }

        return response()->json(['error' => 'User not found'], 404);
    }
}
