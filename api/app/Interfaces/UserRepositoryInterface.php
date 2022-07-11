<?php
namespace App\Interfaces;

use App\Models\User;

interface UserRepositoryInterface
{
    public function getUsers();

    public function getUserById(int $id);

    public function createUser(array $params): User;

    /**
     * @param int $id
     * @param bool $state
     *
     * @return void
     */
    public function setUserActiveById(int $id, bool $state = true): void;

    /**
     * @param User $user
     * @param bool $state
     *
     * @return void
     */
    public function setUserActiveByModel(User $user, bool $state = true): void;

}
