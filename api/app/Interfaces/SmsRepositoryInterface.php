<?php
namespace App\Interfaces;

use App\Models\Sms;
use App\Models\User;

interface SmsRepositoryInterface
{
    /**
     * @param array $params
     *
     * @return Sms
     */
    public function store(array $params): Sms;


    /**
     * @param User $user
     * @param string|null $type
     * 
     * @return array
     */
    public function incomeCall(User $user, ?string $type = null): array;

    /**
     * @param int $userId
     * @param int $code
     *
     * @return bool
     */
    public function isVerifyCodeMatched(int $userId, int $code): bool;

    /**
     * @param int $userId
     *
     * @return bool
     */
    public function isVerifyCodeExpired(int $userId): bool;

    /**
     * @param int $userId
     *
     * @return void
     */
    public function increaseAttempts(int $userId): void;

}
