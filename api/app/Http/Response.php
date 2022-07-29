<?php

namespace App\Http;

use App\Constants;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response as HttpResponse;

class Response extends HttpResponse
{

    /**
     * @param mixed $payload
     * @param int $httpCode
     * @param array $headers
     *
     * @return JsonResponse
     */
    public static function jsonSuccess(mixed $payload = null, int $httpCode = self::HTTP_OK, array $headers = []): JsonResponse
    {

        $params = [
            'message' => 'success',
        ];

        if ((is_array($payload) && empty($payload)) || $payload) {
            $params['data'] = $payload;
        }

        return response()->json($params, $httpCode, $headers);
    }

    /**
     * @param int $code
     * @param string|null $message
     * @param int $httpCode
     * @param array $headers
     *
     * @return JsonResponse
     */
    public static function jsonError(int $code = 0, ?string $message = null, int $httpCode = self::HTTP_OK, array $headers = []): JsonResponse
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

    /**
     * @return JsonResponse
     */
    public static function jsonUnathorized(): JsonResponse
    {
        return response()->json(['message' => Constants::USER_UNATHORIZED_MESSAGE], Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @return JsonResponse
     */
    public static function jsonForbidden(): JsonResponse
    {
        return response()->json(['message' => Constants::USER_FORIDDEN_MESSAGE], Response::HTTP_FORBIDDEN);
    }
}
