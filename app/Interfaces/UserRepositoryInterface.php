<?php
namespace App\Interfaces;

use App\Models\User;

interface UserRepositoryInterface
{
    public function getById(int $id): ?User;

    public function getAllUsers(): array;

    public function getByEmail(string $email): ?User;

    public function getUsersByField(array $data): array;

    public function save(User $user): User;

    public function delete(User $user): bool;

    public function fill(User $user, array $data): User;

    public function createUser(array $userData): User;
}
