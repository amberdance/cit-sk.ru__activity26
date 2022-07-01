<?php

namespace App\Http;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response as HttpResponse;

class Response extends HttpResponse
{

    /**
     * @param array|null $payload
     * @param int $httpCode
     * @param array $haders
     *
     * @return JsonResponse
     */
    public static function jsonSuccess(?array $payload = null, int $httpCode = self::HTTP_OK, array $haders = []): JsonResponse
    {

        $params = [];

        if ($payload) {
            $params['data'] = $payload;
        }

        return response()->json($params, $httpCode, $haders);
    }

    public static function jsonError(int $code = 0, ?string $message = null, int $httpCode = self::HTTP_INTERNAL_SERVER_ERROR, array $headers = []): JsonResponse
    {
        $params = [
            'error' => [
                "code" => $code,
            ],
        ];

        if ($message) {
            $params['error']['message'] = $message;
        }

        return response()->json($params, $httpCode, $headers);

    }
}
