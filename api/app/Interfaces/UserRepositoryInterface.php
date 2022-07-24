<?php
namespace App\Interfaces;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getUsers(): Collection;

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

    /**
     * @param int $id
     * @param array $params
     *
     * @return void
     */
    public function update(int $id, array $params): void;

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
