<?php
namespace App\Interfaces;

use App\Models\SmsApi;

interface RegistrationRepositoryInterface
{
    /**
     * @param array $params
     * 
     * @return SmsApi
     */
    public function store(array $params): SmsApi;

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
