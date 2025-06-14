<?php

namespace App\Services;

use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class AuthService
{
    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    public function register(array $data)
    {
        $data['password'] = bcrypt($data['password']); // Şifrəni hash-lə

        return $this->userRepository->create($data); // İstifadəçi yaradılır
    }

    public function login(array $credentials)
    {
        $user = $this->userRepository->findByEmail($credentials['email']);

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return null;
        }

        $token = $user->createToken('auth-token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    public function logout()
    {
        $user = Auth::user();
        if ($user) {
            $user->tokens()->delete(); // İstifadəçinin bütün token-lərini silir
            Auth::logout(); // İstifadəçini çıxarır
        }
    }
    public function getUserById(int $id): ?User
    {
        return $this->userRepository->findById($id); // ID
    }
}
