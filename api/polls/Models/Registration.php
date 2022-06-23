<?php

namespace RegionalPolls\Models;

use DateTime;

class Registration extends Database
{

    /**
     * @param array $params
     *
     * @return int
     */
    public function registerUser(array $params): int
    {
        return $this->setDbTable('user')->add($params)
            ->getInsertedId();
    }

    /**
     * @param array $params
     *
     * @return void
     */
    public function addVerifyCode(array $params): void
    {

        $this->setDbTable('verify')->add([
            'type'        => $params['type'],
            'user_id'     => $params['user_id'],
            'verify_code' => $params['verify_code'],
            'error_code'  => $params['response']['msg']['err_code'],
            'message_id'  => $params['response']['data']['id'],
        ]);

    }

    /**
     * @param string $phoneNumber
     * @param int $verifyCode
     *
     * @return array
     */
    public function makeIncomeCall(string $phoneNumber, int $verifyCode): array
    {

        $curl   = curl_init();
        $params = [
            "format" => "json",
            "method" => "push_msg",
            "route"  => "pc",
            "key"    => $_ENV['SMS_API_KEY'],
            "phone"  => $phoneNumber,
            "text"   => $verifyCode,
        ];

        curl_setopt($curl, CURLOPT_URL, "http://api.sms-prosto.ru/");
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $result = json_decode(curl_exec($curl), true);

        curl_close($curl);

        return $result['response'] ?? [];
    }

    /**
     * @param string $token
     *
     * @return int
     */
    public function getUserIdByToken(string $token): int
    {
        return $this->setDbTable('user')->select('id')
            ->filter(['token' => $token])
            ->getColumn();
    }

    /**
     * @param string $token
     *
     * @return string
     */
    public function getPhoneNumberByToken(string $token): string
    {
        return $this->setDbTable('user')->select('phone')
            ->filter(['token' => $token])
            ->getColumn();
    }

    /**
     * @param int $userId
     * @param int $code
     *
     * @return bool
     */
    public function isVerifyCodeMatched(int $userId, int $code): bool
    {

        $verifyCode = $this->setDbTable('verify')
            ->select('verify_code')
            ->sort(['id' => 'desc'])
            ->filter(['user_id' => $userId])
            ->getColumn();

        return $code == $verifyCode;
    }

    public function isVerifyCodeExpired(int $userId)
    {
        $createdAt = $this->setDbTable('verify')->select('created_at')
            ->sort(['id' => 'desc'])
            ->filter(['user_id' => $userId])
            ->getColumn();

        $difference = (new DateTime($createdAt))->diff(new DateTime());

        $days    = $difference->d;
        $hours   = $difference->h;
        $minutes = $difference->i;

        return !boolval($days == 0 && $hours == 0 && $minutes < $_ENV['SMS_EXPIRE_TIMEOUT']);

    }

    /**
     * @param string $phone
     *
     * @return bool
     */
    public function isPhoneNumberRegistered(string $phone): bool
    {
        return boolval($this->setDbTable('user')->select('id')
                ->filter(['phone' => $phone])
                ->getRowCount());
    }

    /**
     * @param int $userId
     *
     * @return void
     */
    public function increaseAttempts(int $userId): void
    {
        $verifyCodeId = $this->setDbTable('verify')->select('id')
            ->sort(['id' => 'desc'])
            ->filter(['user_id' => $userId])
            ->getColumn();

        $this->customQuery("UPDATE verify SET attempts = attempts + 1 WHERE id = $verifyCodeId");
    }
}
