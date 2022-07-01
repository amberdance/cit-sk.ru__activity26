<?php

namespace RegionalPolls\Http;

class Response
{

    /**
     * @param mixed $data
     * @param bool $wrapToArray
     *
     * @return void
     */
    public function json($data, bool $wrapToArray = false): void
    {

        if ($wrapToArray) {
            $data = [$data];
        }

        echo json_encode($data);

        exit;
    }

    /**
     * @param mixed $cache
     *
     * @return void
     */
    public static function responseCacheData($cache): void
    {

        echo json_encode($cache);

        exit;

    }

    /**
     * @param string $value
     *
     * @return void
     */
    public static function header(string $value): void
    {
        header($value);
    }

    /**
     * @param string $requestMethod
     *
     * @return void
     */
    public static function HttpMethod(string $requestMethod): void
    {

        $requestMethod = explode(",", strtoupper(trim(str_replace(" ", "", $requestMethod))));

        if (!in_array($_SERVER['REQUEST_METHOD'], $requestMethod)) {
            self::HttpCode(405);
        }

        header("Access-Control-Allow-Methods:" . implode(",", $requestMethod));
        header("Allow:" . implode(",", $requestMethod));
    }

    /**
     * @param int $code
     *
     * @return void
     */
    public static function HttpCode(int $code): void
    {
        http_response_code($code);

        exit;
    }

    /**
     * @param array|null $data
     * @param int $status
     *
     * @return void
     */
    public static function success(?array $data = null, int $status = 1): void
    {
        $response = [
            "status" => $status,
        ];

        if ($data) {
            $response['data'] = $data;
        }

        echo json_encode($response);

        exit;
    }

    /**
     * @param int $code
     * @param array|null $data
     *
     * @return void
     */
    public static function error(int $code = 0, ?string $errorMessage = null): void
    {
        $response = [
            "code" => $code,
        ];

        $response['error'] = $errorMessage ?? 'Unhandled error';

        echo json_encode($response);

        exit;

    }

}
