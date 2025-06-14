<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public function create(array $data): User
    {
        return User::create($data); // İstifadəçi yaradılır
    }

    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first(); // Email-ə görə tapılır
    }

    public function update(User $user, array $data): User
    {
        $user->update($data); // İstifadəçi məlumatları yenilənir
        return $user;
    }


    public function delete(User $user): bool
    {
        return $user->delete(); // İstifadəçi silinir
    }

    public function findById(int $id): ?User
    {
        return User::find($id); // ID-ə görə istifadəçi tapılır
    }
}
