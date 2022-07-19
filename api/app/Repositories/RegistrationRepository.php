<?php
namespace App\Repositories;

use App\Interfaces\RegistrationRepositoryInterface;
use App\Models\Registration;
use DateTime;

class RegistrationRepository implements RegistrationRepositoryInterface
{

    /**
     * @param array $params
     *
     * @return Registration
     */
    public function store(array $params): Registration
    {
        return Registration::create([
            'type'        => $params['type'] ?? 'call',
            'user_id'     => $params['user_id'],
            'verify_code' => $params['verify_code'],
            'error_code'  => $params['response']['msg']['err_code'],
            'message_id'  => $params['response']['data']['id'],
        ]);
    }

    /**
     * @param int $userId
     *
     * @return bool
     */
    public function isVerifyCodeExpired(int $userId): bool
    {

        $createdAt = Registration::select('created_at')
            ->where('user_id', $userId)
            ->orderByDesc('id')
            ->firstOrFail()['created_at'];

        $difference = (new DateTime($createdAt))->diff(new DateTime());
        $days       = $difference->d;
        $hours      = $difference->h;
        $minutes    = $difference->i;

        return boolval($days == 0 && $hours == 0 && $minutes > $_ENV['SMS_EXPIRE_MINUTES_TIMEOUT']);
    }

    /**
     * @param int $userId
     *
     * @return void
     */
    public function increaseAttempts(int $userId): void
    {
        Registration::where('user_id', $userId)
            ->orderByDesc('id')
            ->firstOrFail()
            ->increment('attempts');
    }

    /**
     * @param int $userId
     * @param int $codeToCompare
     *
     * @return bool
     */
    public function isVerifyCodeMatched(int $userId, int $codeToCompare): bool
    {
        $code = Registration::select('verify_code')
            ->where('user_id', $userId)
            ->orderByDesc('id')
            ->firstOrFail()['verify_code'];

        return boolval($code == $codeToCompare);
    }
}
