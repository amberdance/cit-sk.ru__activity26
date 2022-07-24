<?php

namespace App\Http\Controllers;

use App\Helpers\ValidationHelper;
use App\Http\Constants;
use App\Http\Response;
use App\Interfaces\UserRepositoryInterface;
use App\Lib\EdrosAPI;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class UserController extends Controller
{

    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;

    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {

        $request->validate([
            'firstName'       => 'required',
            'lastName'        => 'required',
            'confirmPassword' => 'required',
            'address'         => 'required',
            'districtId'      => 'required',
            'address'         => 'required',
            'email'           => 'required|email',
            'birthday'        => ['required', 'regex:' . ValidationHelper::BIRTHDAY_REGEXP],
            'password'        => ['required', 'regex:' . ValidationHelper::PASSWORD_REGEXP],
            'phone'           => ['required', 'regex:' . ValidationHelper::PHONE_REGEXP],
        ]);

        if ($request->password !== $request->confirmPassword) {
            return response()->json(['message' => Constants::MISMATCH_PASSWORDS], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $user       = $this->userRepository->store($request->all());
            $verifyCode = rand(1000, 9999);
            $params     = [
                'user_id'     => $user->id,
                'verify_code' => $verifyCode,
                'response'    => \App\Models\Registration::makeIncomeCall($user->phone, $verifyCode),
            ];

            (new \App\Repositories\RegistrationRepository)->store($params);

            $associateResponse = EdrosAPI::associate($request->all());

            if ($associateResponse['data']['ok'] && $associateResponse['data']['id']) {
                $this->userRepository->update($user->id, [
                    'is_associated' => true,
                    'associate_id'  => $associateResponse['data']['id'],
                ]);
            }

            return Response::jsonSuccess([
                'uuid'  => $user->uuid,
                'phone' => $user->phone,
            ],
                Response::HTTP_CREATED
            );
        } catch (Throwable $e) {

            if (property_exists($e, 'errorInfo')) {
                $error = $e->errorInfo;

                // Dublicate entry error
                if ($error[1] == 1062) {
                    return Response::jsonError($error[1], $error[2]);
                }
            }

            return Response::jsonError(0, $e->getMessage());
        }
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function getUser(int $id): JsonResponse
    {
        return Response::jsonSuccess($this->userRepository->getUserById($id));
    }

}
