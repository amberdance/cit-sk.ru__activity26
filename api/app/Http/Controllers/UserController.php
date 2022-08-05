<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Helpers\ValidationHelper;
use App\Http\Response;
use App\Interfaces\SmsRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Lib\EdrosAPI;
use App\Models\Sms;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Throwable;

class UserController extends Controller
{

    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var SmsRepositoryInterface
     */
    private $smsRepository;

    public function __construct(UserRepositoryInterface $userRepository, SmsRepositoryInterface $smsRepository)
    {
        $this->userRepository = $userRepository;
        $this->smsRepository  = $smsRepository;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {

        try {
            $request->validate([

                'confirmPassword' => 'required',
                'address'         => 'required',
                'districtId'      => 'required',
                'address'         => 'required',
                'firstName'       => ['required', 'regex:' . ValidationHelper::CYRILIC_REGEXP],
                'lastName'        => ['required', 'regex:' . ValidationHelper::CYRILIC_REGEXP],
                'patronymic'      => ['regex:' . ValidationHelper::CYRILIC_REGEXP],
                'birthday'        => ['required', 'regex:' . ValidationHelper::BIRTHDAY_REGEXP],
                'password'        => ['required', 'regex:' . ValidationHelper::PASSWORD_REGEXP],
                'phone'           => ['required', 'regex:' . ValidationHelper::PHONE_REGEXP],
            ]);

            if ($request->email) {
                $request->validate([
                    'email' => 'email',
                ]);
            }

            if ($request->password !== $request->confirmPassword) {
                return response()->json(['message' => Constants::MISMATCH_PASSWORDS], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $user       = $this->userRepository->store($request->all());
            $verifyCode = rand(1000, 9999);
            $params     = [
                'user_id'     => $user->id,
                'verify_code' => $verifyCode,
                'response'    => Sms::makeIncomeCall($user->phone, $verifyCode),
            ];

            $this->smsRepository->store($params);

            return Response::jsonSuccess([
                'uuid'  => $user->uuid,
                'phone' => $user->phone,
            ],
                Response::HTTP_CREATED
            );
        } catch (ValidationException $e) {
            return Response::jsonError(422, $e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);

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
    public function show(int $id): JsonResponse
    {
        return Response::jsonSuccess($this->userRepository->getUserById($id));
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
    public function recovery(Request $request): JsonResponse
    {

        $user = null;

        if (preg_match(ValidationHelper::PHONE_REGEXP, $request->login)) {
            $user = $this->userRepository->getUserByPhone(ValidationHelper::replacePhoneNumber($request->login));
        } else {
            $user = $this->userRepository->getUserByEmail($request->login);
        }

        $verifyCode = rand(1000, 9999);
        $params     = [
            'user_id'     => $user->id,
            'verify_code' => $verifyCode,
            'type'        => 'recovery',
            'response'    => Sms::makeIncomeCall($user->phone, $verifyCode),
        ];

        $this->smsRepository->store($params);

        return Response::jsonSuccess(['uuid' => $user->uuid]);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function resetPassword(Request $request): JsonResponse
    {

        try {
            $request->validate([
                'password'        => ['required', 'regex:' . ValidationHelper::PASSWORD_REGEXP],
                'confirmPassword' => 'required',
            ]);

            if ($request->password !== $request->confirmPassword) {
                return response()->json(['message' => Constants::MISMATCH_PASSWORDS], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $user = $this->userRepository->getUserByUUID($request->uuid);

            $this->userRepository->resetPassword($user, $request->password)->setUserActiveByModel($user);

            return Response::jsonSuccess();
        } catch (Throwable $e) {
            return Response::jsonError(0, $e->getMessage() ?? "Some error here");
        }
    }
}
