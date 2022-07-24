<?php

namespace App\Helpers;

class CurlHelper
{

    /**
     * @param string $url
     * @param array|null $params
     * @param array|null $headers
     *
     * @return array
     */
    public static function get(string $url, ?array $params = null, ?array $headers = null): array
    {
        return self::initCurl($url, 'GET', $params, $headers);
    }

    /**
     * @param string $url
     * @param array|null $params
     * @param array|null $headers
     *
     * @return array
     */
    public static function post(string $url, ?array $params = null, ?array $headers = null): array
    {
        return self::initCurl($url, 'POST', $params, $headers);
    }

    /**
     * @param string $url
     * @param string $requestMethod
     * @param array|null $params
     * @param array|null $headers
     *
     * @return array
     */
    private static function initCurl(string $url, string $requestMethod, ?array $params = null, ?array $headers = null): array
    {

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_ENCODING       => "",
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 0,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => $requestMethod,
            CURLOPT_HTTPHEADER     => $headers ?? [],
        ]);

        if (strtolower($requestMethod) == 'post') {
            curl_setopt($curl, CURLOPT_POST, 1);

        };

        if ($params) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($params));
        }

        $response = curl_exec($curl);
        $info     = curl_getinfo($curl);

        curl_close($curl);

        return [
            'data' => json_decode($response, true),
            'info' => $info,
        ];
    }
}
