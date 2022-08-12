<?php
namespace App\Interfaces;

use App\Http\Resources\UserCollection;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{

    /**
     * @param array $params
     *
     * @return UserCollection
     */
    public function getUsers(array $params): UserCollection;

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
     * @param string $phone
     *
     * @return User
     */
    public function getUserByPhone(string $phone): User;

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
     * @param array|int $id
     *
     * @return void
     */
    public function delete($id): void;

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

    /**
     * @param User $user
     * @param int $associateId
     *
     * @return void
     */
    public function associate(User $user, int $associateId): void;

    /**
     * @param int $userId
     *
     * @return Collection
     */
    public function getPassedPollsId(int $userId);

    /**
     * @param User $user
     * @param mixed $password
     *
     * @return UserRepository
     */
    public function resetPassword(User $user, string $password): UserRepository;

}
