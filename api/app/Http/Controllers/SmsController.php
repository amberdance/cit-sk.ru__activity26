<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Exceptions\SmsException;
use App\Http\Response;
use App\Interfaces\SmsRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Lib\EdrosAPI;
use App\Models\Sms;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class SmsController extends Controller
{

    /**
     * @var SmsRepositoryInterface
     */
    private $smsRepository;

    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @param SmsRepositoryInterface $smsRepository
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(SmsRepositoryInterface $smsRepository, UserRepositoryInterface $userRepository)
    {

        $this->smsRepository  = $smsRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function verifyCode(Request $request): JsonResponse
    {

        try {
            $user                = $this->userRepository->getUserByUUID($request->uuid);
            $isVerifyCodeExpired = $this->smsRepository->isVerifyCodeExpired($user->id);

            if ($isVerifyCodeExpired) {
                $user->delete();

                return Response::jsonError(Constants::EXPIRED_SMS_CODE, Constants::EXPIRED_SMS_MESSAGE);
            }

            if ($this->smsRepository->isVerifyCodeMatched($user->id, (int) $request->code)) {
                $this->userRepository->setUserActiveByModel($user);

                $associateResponse = EdrosAPI::associate($user);
       
                if ($associateResponse['data']['ok'] && $associateResponse['data']['id']) {
                    $this->userRepository->associate($user, $associateResponse['data']['id']);
                }

                return Response::jsonSuccess();
            } else {
                $this->smsRepository->increaseAttempts($user->id);

                return Response::jsonError(Constants::MISMATCH_SMS_CODE, Constants::MISMATCH_SMS_MESSAGE);
            }
        } catch (SmsException $e) {
            if ($user->id) {
                $user->delete();
            }

            return Response::jsonError($e->getCode(), $e->getMessage());
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
     * @param Response $response
     *
     * @return JsonResponse
     */
    public function resetCode(Request $request): JsonResponse
    {

        $user       = $this->userRepository->getUserByUUID($request->uuid);
        $verifyCode = rand(1000, 9999);

        $this->smsRepository->store([
            'user_id'     => $user->id,
            'verify_code' => $verifyCode,
            'response'    => Sms::makeIncomeCall($user->phone, $verifyCode),
        ]);

        return Response::jsonSuccess();
    }
}
