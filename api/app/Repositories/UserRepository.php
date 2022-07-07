<?php
namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserRepository implements UserRepositoryInterface
{

    public function getUsers()
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
        return User::where(['is_active' => true, 'id' => $id])->findOrFail();
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

    public function deleteUser()
    {
        //
    }

    public function updateUser()
    {
        //
    }

    public function isRegistered(int $id)
    {
        return (bool) User::select('id')->where('id', $id)->count();
    }
}
