<?php

namespace App\Lib;

use App\Helpers\CurlHelper;

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
     * @param array $user
     *
     * @return array
     */
    public static function associate(array $user): array
    {

        return CurlHelper::post('https://mob-api.er.ru/pub-api/26/associate', $user, self::getHeaders());
    }

    /**
     * @return array
     */
    private static function getHeaders(): array
    {
        return [
            "Content-Type: application/json",
            "Authorization: Basic " . base64_encode(self::$BASIC_AUTH_USERNAME . ":" . self::$BASIC_AUTH_PASSWORD),
        ];
    }

}
