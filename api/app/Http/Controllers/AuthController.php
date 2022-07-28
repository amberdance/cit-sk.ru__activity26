<?php

namespace App\Http\Controllers;

use App\Helpers\ValidationHelper;
use App\Http\Response;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        $isLoginPhone = preg_match(ValidationHelper::PHONE_REGEXP, $request->login);

        $request->validate([
            "login"    => $isLoginPhone ? ['required', 'regex:' . ValidationHelper::PHONE_REGEXP] : "required|email",
            "password" => "required",
        ]);

        try {
            $user = $isLoginPhone
            ? (new UserRepository)->getUserByPhone(ValidationHelper::replacePhoneNumber($request->login))
            : (new UserRepository)->getUserByEmail($request->login);

            if (!$user->is_active) {
                return Response::jsonForbidden();
            }
        } catch (ModelNotFoundException $e) {
            return Response::jsonUnathorized();
        }

        if (!$token = auth()->attempt([
            $isLoginPhone ? 'phone' : 'email' => $isLoginPhone ? ValidationHelper::replacePhoneNumber($request->login) : $request->login,
            'password'                        => $request->password,
        ])) {
            return Response::jsonUnathorized();
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

        return response()->json(auth()->user());

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
