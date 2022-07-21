<?php
namespace App\Repositories;

use App\Helpers\ValidationHelper;
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
            'first_name'  => $params['firstName'],
            'last_name'   => $params['lastName'],
            'patronymic'  => $params['patronymic'],
            'email'       => $params['email'],
            'phone'       => ValidationHelper::replacePhoneNumber($params['phone']),
            'address'     => $params['address'],
            'district_id' => $params['districtId'],
            'birthday'    => date('Y-m-d', strtotime($params['birthday'])),
            'password'    => Hash::make($params['password']),
            'uuid'        => Str::uuid(),
            'ip_address'  => request()->ip(),
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

    public function getUsersCount(bool $onlyVerified = false): int
    {
        $result = 0;

        if ($onlyVerified) {
            return $result = User::select('id')->where('is_active', true)->count();
        } else {
            $result = User::all("id")->count();
        }

        return $result;
    }
}
