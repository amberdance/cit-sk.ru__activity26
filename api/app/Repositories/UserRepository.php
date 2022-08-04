<?php
namespace App\Repositories;

use App\Helpers\ValidationHelper;
use App\Interfaces\UserRepositoryInterface;
use App\Models\Polls\PollAnswer;
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

    /**
     * @param string $phone
     *
     * @return User
     */
    public function getUserByPhone(string $phone): User
    {
        return User::where('phone', $phone)->firstOrFail();
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
     * @param array $params
     *
     * @return void
     */
    public function update(int $id, array $params): void
    {
        User::findOrFail($id)->update($params);
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

    /**
     * @param bool $onlyVerified
     *
     * @return int
     */
    public function getUsersCount(bool $onlyVerified = true): int
    {
        $result = 0;

        if ($onlyVerified) {
            return $result = User::select('id')->where('is_active', true)->count();
        } else {
            $result = User::all("id")->count();
        }

        return $result;
    }

    /**
     * @param int $userId
     *
     * @return array
     */
    public function getPassedPollsId(int $userId)
    {
        $result     = [];
        $collection = PollAnswer::select('poll_id')
            ->where('user_id', $userId)
            ->groupBy('poll_id')
            ->get();

        foreach ($collection as $answer) {
            $result[] = $answer['poll_id'];
        }

        return $result;
    }

    /**
     * @param User $user
     * @param string $password
     *
     * @return UserRepository
     */
    public function resetPassword(User $user, string $password): UserRepository
    {
        $user->password = Hash::make($password);
        $user->save();

        return $this;
    }

    /**
     * @param User $user
     * @param int $associateId
     *
     * @return void
     */
    public function associate(User $user, int $associateId): void
    {
        $user->is_associated = true;
        $user->associate_id  = $associateId;
        $user->save();
    }
}
