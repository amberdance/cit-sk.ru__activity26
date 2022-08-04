<?php

namespace App\Lib;

use App\Helpers\CurlHelper;
use App\Models\User;

class EdrosAPI
{

    private static $BASIC_AUTH_USERNAME = 'user';
    private static $BASIC_AUTH_PASSWORD = '626Gfhjkm';

    /**
     * @return array
     */
    public static function getDistricts(): array
    {

        return CurlHelper::get('https://mob-api.er.ru/pub-api/26/districts', null, self::getHeaders());
    }

    /**
     * @param User $user
     *
     * @return array
     */
    public static function associate(User $user): array
    {

        $params = [
            'first_name'  => $user->first_name,
            'last_name'   => $user->last_name,
            'patronymic'  => $user->patronymic ?? null,
            'email'       => $user->email,
            'phone'       => $user->phone,
            'district_id' => $user->district_id,
            'address'     => $user->address,
            'birthday'    => date('Y-m-d', strtotime($user->birthday)),
        ];

        return CurlHelper::post('https://mob-api.er.ru/pub-api/26/associate', $params, self::getHeaders());
    }

    /**
     * @return array
     */
    private static function getHeaders(): array
    {
        return [
            "Content-Type: application/json",
            'accept: application/json',
            "Authorization: Basic " . base64_encode(self::$BASIC_AUTH_USERNAME . ":" . self::$BASIC_AUTH_PASSWORD),
        ];
    }

}
