<?php
namespace App\Repositories;

use App\Helpers\ValidationHelper;
use App\Http\Resources\UserCollection;
use App\Interfaces\UserRepositoryInterface;
use App\Models\Polls\PollAnswer;
use App\Models\User;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Throwable;

class UserRepository implements UserRepositoryInterface
{

    /**
     * @return ResourceCollection
     */
    public function getUsers(): UserCollection
    {
        return new UserCollection(User::all()->take(100));
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

    /**
     * @return void
     */
    public static function moveUsersToInactiveTable(): void
    {

        $users = User::where([
            'is_active'     => false,
            'is_associated' => false,
        ])->get();

        foreach ($users as $key => $user) {
            try {
                DB::table('users_inactive')->insert([
                    'uuid'              => $user->uuid,
                    'created_at'        => $user->created_at,
                    'updated_at'        => $user->updated_at,
                    'email_verified_at' => $user->email_verified_at,
                    'first_name'        => $user->first_name,
                    'last_name'         => $user->last_name,
                    'patronymic'        => $user->patronymic,
                    'district_id'       => $user->district_id,
                    'address'           => $user->address,
                    'birthday'          => $user->birthday,
                    'email'             => $user->email,
                    'password'          => $user->password,
                    'phone'             => $user->phone,
                    'ip_address'        => $user->ip_address,
                    'is_active'         => false,
                    'is_admin'          => $user->is_admin,
                    'points'            => $user->points,
                    'is_associated'     => false,
                    'associate_id'      => $user->associate_id,
                ]);

                $user->delete();

            } catch (Throwable $e) {

                if (property_exists($e, 'errorInfo')) {
                    $error = $e->errorInfo;

                    // Dublicate entry error
                    if ($error[1] == 1062) {
                        $user->delete();

                        continue;
                    }
                }
            }
        }
    }
}
