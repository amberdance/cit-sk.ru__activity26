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
     * @return mixed
     */
    public function getUserById(int $id): mixed
    {
        return User::where(['is_active' => true, 'id' => $id])->firstOrFail();
    }

    public function createUser(array $params): User
    {

        return User::create([
            'name'       => $params['name'],
            'surname'    => $params['surname'],
            'patronymic' => $params['patronymic'],
            'email'      => $params['email'],
            'password'   => Hash::make($params['password']),
            'uuid'       => Str::uuid(),
            'phone'      => $params['phone'],
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
        return (bool) User::select('id')->where('id', $id)->count();
    }
}
