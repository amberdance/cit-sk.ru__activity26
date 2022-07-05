<?php

namespace App\Http\Controllers;

use App\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{




    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {

        $request->validate([
            "login"    => "required|email",
            "password" => "required",
        ]);

        if (!$token = auth()->attempt([
            'email'    => $request->login,
            'password' => $request->password,
        ])) {
            return response()->json(['message' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        return Response::jsonSuccess($this->getJsonJwtData($token));
    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {

        auth()->logout();

        return Response::jsonSuccess();
    }

    /**
     * @return JsonResponse
     */
    public function me(): JsonResponse
    {

        return response()->json([
            'data' => auth()->user(),
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function refreshToken(): JsonResponse
    {
        return Response::jsonSuccess($this->getJsonJwtData(auth()->refresh()));
    }

    /**
     * @param string $token
     *
     * @return array
     */
    private function getJsonJwtData(string $token): array
    {
        return [
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth()->factory()->getTTL() * 60,
            'user'         => auth()->user(),
        ];
    }
}
