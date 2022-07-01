<?php
namespace App\Interfaces;

use App\Models\User;

interface UserRepositoryInterface
{
    public function getUsers();

    public function getUserById(int $id);

    public function createUser(array $params): User;

    public function deleteUser();

    public function updateUser();

    public function isRegistered(int $id);
}
