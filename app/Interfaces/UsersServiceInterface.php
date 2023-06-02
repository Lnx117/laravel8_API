<?php
namespace App\Interfaces;

interface UsersServiceInterface
{
    public function getUsersList();

    public function updateUserByIdOrEmail($request, $user);

    public function getUserByIdOrEmail($idOrEmail);

    public function deleteUserByIdOrEmail($idOrEmail);

    public function getUsersByField(array $request);
}
