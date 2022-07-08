<?php
namespace App\Interfaces;

use App\Models\Registration;

interface RegistrationRepositoryInterface
{
    public function store(array $params): Registration;

    public function isVerifyCodeMatched(int $userId, int $code): bool;

    public function isVerifyCodeExpired(int $userId): bool;

    public function increaseAttempts(int $userId): void;

}
