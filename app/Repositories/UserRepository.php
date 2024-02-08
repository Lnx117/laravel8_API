<?php
namespace App\Repositories;

use App\Models\User;
use App\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function getAllUsers(): array
    {
        return User::orderBy('id', 'desc')->get()->toArray();
    }
    
    public function getById(int $id): ?User
    {
        return User::find($id);
    }

    public function getByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function save(User $user): User
    {
        $user->save();
        return $user;
    }

    public function delete(User $user): bool
    {
        return $user->delete();
    }

    public function fill(User $user, array $data): User
    {
        $user->fill($data);
        return $user;
    }

    public function createUser(array $userData): User
    {
        return User::create($userData);
    }

    public function getUsersByField(array $fields): array
    {
        $query = User::query();

        foreach ($fields as $field => $value) {
            $query->where($field, $value)->orderBy('id', 'desc');
        }

        return $query->get()->toArray();
    }
}
