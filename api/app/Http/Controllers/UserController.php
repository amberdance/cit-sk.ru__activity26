<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Helpers\ValidationHelper;
use App\Http\Response;
use App\Interfaces\SmsRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Lib\EdrosAPI;
use App\Repositories\UserRepository;
use DateTime;
use Exception;
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
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return Response::jsonSuccess($this->userRepository->getUsers($request->all()));
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
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {

        try {
            $request->validate([
                'confirmPassword' => 'required',
                'districtId'      => 'required',
                'address'         => ['required', 'regex:' . ValidationHelper::ADDRESS_REGEXP],
                'firstName'       => ['required', 'regex:' . ValidationHelper::CYRILIC_REGEXP],
                'lastName'        => ['required', 'regex:' . ValidationHelper::CYRILIC_REGEXP],
                'patronymic'      => ['regex:' . ValidationHelper::CYRILIC_REGEXP],
                'birthday'        => ['required', 'regex:' . ValidationHelper::BIRTHDAY_REGEXP],
                'password'        => ['required', 'regex:' . ValidationHelper::PASSWORD_REGEXP],
                'phone'           => ['required', 'regex:' . ValidationHelper::PHONE_REGEXP],
            ]);

            if ($request->email != "") {
                $request->validate([
                    'email' => ['regex:' . ValidationHelper::EMAIL_REGEXP],
                ]);
            }

            if ($request->password !== $request->confirmPassword) {
                return response()->json(['message' => Constants::MISMATCH_PASSWORDS], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $user = $this->userRepository->store($request->all());
            $this->smsRepository->incomeCall($user);

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
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function associate(Request $request)
    {

        if (is_array($request->id)) {
            $err = [];

            foreach ($request->id as $id) {
                try {
                    $this->associateCallback($id);
                } catch (Exception $e) {
                    $err[] = $e->getMessage();

                    continue;
                }
            }

            return Response::jsonSuccess($err ? ['errors' => $err] : null);
        } else {
            try {
                $this->associateCallback($request->id);
            } catch (Exception $e) {
                return Response::jsonError($e->getCode(), $e->getMessage());
            }
        }
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function delete(Request $request): JsonResponse
    {

        $this->userRepository->delete($request->id);

        return Response::jsonSuccess();
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function transferUser(Request $request): JsonResponse
    {
        try {
            isset($request['merge']) ? UserRepository::mergeUsersWithInactiveTable() : UserRepository::moveUsersToInactiveTable();
            return Response::jsonSuccess();
        } catch (Throwable $e) {
            return Response::jsonError(0, $e->getMessage());
        }
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

        $this->smsRepository->store($this->smsRepository->incomeCall($user, 'recovery'));

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

    /**
     * @param int $id
     *
     * @return void
     */
    private function associateCallback(int $id): void
    {

        $user = $this->userRepository->getUserById($id);

        if ($user->is_associated || (new DateTime($user->birthday))->diff(new DateTime())->y <= 18) {
            return;
        }

        $response = EdrosAPI::associate($user)['data'];

        if (isset($response['ok']) && $response['ok'] == true) {
            $this->userRepository->associate($user, $response['id']);
        } else {
            $message = $response['message'] ?? null;

            throw new Exception("[Associate error][User id: $id] {$response['error']} $message");
        }
    }
}
