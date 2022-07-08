<?php
namespace App\Interfaces;

use App\Models\User;

interface UserRepositoryInterface
{
    public function getUsers();

    /**
     * @param int $id
     *
     * @return User
     */
    public function getUserById(int $id): User;

    /**
     * @param string $uuid
     *
     * @return User
     */
    public function getUserByUUID(string $uuid): User;

    /**
     * @param string $email
     *
     * @return User
     */
    public function getUserByEmail(string $email): User;

    /**
     * @param array $params
     *
     * @return User
     */
    public function store(array $params): User;

    public function deleteUser();

    public function updateUser();

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
