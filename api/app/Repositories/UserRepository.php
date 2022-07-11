<?php
namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserRepository implements UserRepositoryInterface
{

    /**
     * @return Collection
     */
    public function getUsers(): Collection
    {
        return User::all();
    }

    /**
     * @param int $id
     *
     * @return User
     */
    public function getUserById(int $id): User
    {
        return User::findOrFail($id);
    }

    /**
     * @param string $uuid
     *
     * @return User
     */
    public function getUserByUUID(string $uuid): User
    {
        return User::where('uuid', $uuid)->firstOrFail();
    }

    /**
     * @param string $email
     *
     * @return User
     */
    public function getUserByEmail(string $email): User
    {
        return User::where('email', $email)->firstOrFail();
    }

    public function store(array $params): User
    {
        return User::create([
            'name'       => $params['name'],
            'surname'    => $params['surname'],
            'patronymic' => $params['patronymic'],
            'email'      => $params['email'],
            'phone'      => $params['phone'],
            'password'   => Hash::make($params['password']),
            'uuid'       => Str::uuid(),
            'ip_address' => request()->ip(),
        ]);
    }

    /**
     * @param int $id
     * @param bool $state
     * @param mixed
     *
     * @return void
     */
    public function setUserActiveById(int $id, $state = true): void
    {
        User::findOrFail($id)->update(['is_active' => $state]);
    }

    /**
     * @param User $user
     * @param bool $state
     *
     * @return void
     */
    public function setUserActiveByModel(User $user, $state = true): void
    {
        $user->is_active = $state;
        $user->save();
    }
}
