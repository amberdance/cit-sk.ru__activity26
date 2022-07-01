<?php
namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{

    public function getUsers()
    {
        return User::all();
    }

    public function getUserById(int $id)
    {
        return User::where('id', $id)->get();
    }

    public function createUser(array $params): User
    {
        return User::create([
            'login'      => 'test',
            'password'   => 'test',
            'name'       => $params['name'],
            'surname'    => $params['surname'],
            'patronymic' => $params['patronymic'],
            'phone'      => $params['phone'],
            'ip_address' => request()->ip(),
            'token'      => \Illuminate\Support\Str::random(30),
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
