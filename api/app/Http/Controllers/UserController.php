<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Exceptions\PhoneVerifyException;
use App\Helpers\ValidationHelper;
use App\Http\Response;
use App\Interfaces\UserRepositoryInterface;
use App\Lib\EdrosAPI;
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

        try {
            $request->validate([
                'firstName'       => 'required',
                'lastName'        => 'required',
                'confirmPassword' => 'required',
                'address'         => 'required',
                'districtId'      => 'required',
                'address'         => 'required',
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

            $user = $this->userRepository->store($request->all());

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
        } catch (ValidationException $e) {
            return Response::jsonError(422, $e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);

        } catch (PhoneVerifyException $e) {
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

            return Response::jsonError($e->getCode() ?? 0, $e->getMessage());
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
