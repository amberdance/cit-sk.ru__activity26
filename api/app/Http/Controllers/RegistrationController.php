<?php

namespace App\Http\Controllers;

use App\Http\Constants;
use App\Http\Response;
use App\Interfaces\RegistrationRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Lib\EdrosAPI;
use App\Models\Registration;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{

    /**
     * @var RegistrationRepositoryInterface
     */
    private $registrationRepository;

    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @param UserRepositoryInterface $registrationRepository
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(RegistrationRepositoryInterface $registrationRepository, UserRepositoryInterface $userRepository)
    {

        $this->registrationRepository = $registrationRepository;
        $this->userRepository         = $userRepository;
    }

    /**
     * @return JsonResponse
     */
    public function districts(): JsonResponse
    {

        $response = EdrosAPI::getDistricts();

        switch ($response['info']['http_code']) {
            case 401:
                return Response::jsonUnathorized();
                break;

            case 403:
                return Response::jsonForbidden();
                break;

            case 404:

            case 200:
                return Response::jsonSuccess($response['data']);
                break;
        }
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function verifyCode(Request $request): JsonResponse
    {

        $user                = $this->userRepository->getUserByUUID($request->uuid);
        $isVerifyCodeExpired = $this->registrationRepository->isVerifyCodeExpired($user->id);

        if ($isVerifyCodeExpired) {
            return Response::jsonError(Constants::EXPIRED_SMS_CODE, Constants::EXPIRED_SMS_MESSAGE);
        }

        if ($this->registrationRepository->isVerifyCodeMatched($user->id, (int) $request->code)) {
            $this->userRepository->setUserActiveByModel($user);

            return Response::jsonSuccess();
        } else {
            $this->registrationRepository->increaseAttempts($user->id);

            return Response::jsonError(Constants::MISMATCH_SMS_CODE, Constants::MISMATCH_SMS_MESSAGE);
        }
    }

    /**
     * @param Response $response
     *
     * @return JsonResponse
     */
    public function resetCode(Request $request): JsonResponse
    {

        $user       = $this->userRepository->getUserByUUID($request->uuid);
        $verifyCode = rand(1000, 9999);

        $this->registrationRepository->store([
            'user_id'     => $user->id,
            'verify_code' => $verifyCode,
            'response'    => Registration::makeIncomeCall($user->phone, $verifyCode),
        ]);

        return Response::jsonSuccess();
    }
}
