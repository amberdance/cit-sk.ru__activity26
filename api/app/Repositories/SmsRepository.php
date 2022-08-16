<?php
namespace App\Repositories;

use App\Interfaces\SmsRepositoryInterface;
use App\Models\Sms;
use App\Models\User;
use DateTime;

class SmsRepository implements SmsRepositoryInterface
{

    /**
     * @param array $params
     *
     * @return Sms
     */
    public function store(array $params): Sms
    {
        return Sms::create([
            'type'        => $params['type'] ?? 'call',
            'user_id'     => $params['user_id'],
            'verify_code' => $params['verify_code'],
            'error_code'  => $params['response']['msg']['err_code'],
            'message_id'  => $params['response']['data']['id'],
        ]);
    }


    /**
     * @param User $user
     * @param string|null $type
     * 
     * @return array
     */
    public function incomeCall(User $user, ?string $type = null): array
    {

        $verifyCode = rand(1000, 9999);
        $params     = [
            'user_id'     => $user->id,
            'verify_code' => $verifyCode,
            'type'        => $type ?? null,
            'response'    => Sms::makeIncomeCall($user->phone, $verifyCode),
        ];

        $this->store($params);

        return $params;

    }

    /**
     * @param int $userId
     *
     * @return bool
     */
    public function isVerifyCodeExpired(int $userId): bool
    {

        $sms = Sms::select('created_at')
            ->where('user_id', $userId)
            ->orderByDesc('id')
            ->firstOrFail();

        $difference = (new DateTime($sms->created_at))->diff(new DateTime());
        $days       = $difference->d;
        $hours      = $difference->h;
        $minutes    = $difference->i;

        return boolval($days == 0 && $hours == 0 && $minutes > $_ENV['SMS_EXPIRE_MINUTES_TIMEOUT']);
    }

    /**
     * @param int $userId
     * @param int $code
     *
     * @return bool
     */
    public function isVerifyCodeMatched(int $userId, int $code): bool
    {
        $sms = Sms::select('verify_code')
            ->where('user_id', $userId)
            ->orderByDesc('id')
            ->firstOrFail();

        return boolval($code == $sms->verify_code);
    }

    /**
     * @param int $userId
     *
     * @return void
     */
    public function increaseAttempts(int $userId): void
    {
        Sms::where('user_id', $userId)
            ->orderByDesc('id')
            ->firstOrFail()
            ->increment('attempts');
    }
}
