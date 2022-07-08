<?php

namespace App\Http\Controllers;

use App\Http\Constants;
use App\Http\Response;
use App\Interfaces\UserRepositoryInterface;
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
            'name'            => 'required',
            'surname'         => 'required',
            'confirmPassword' => 'required',
            'email'           => 'required|email',
            'password'        => ['required', 'regex:/^(?=(.*[a-z]){3,})(?=(.*[A-Z]){2,})(?=(.*[0-9]){1,})(?=(.*[!@#$%^&*()\-__+.]){1,}).{8,}$/'],
            'phone'           => ['required', 'regex:/^(\+7[\- ]?)?(\([9]{1}\d{2}\)?[\- ]?)?[\d\- ]{5,10}$/'],
        ]);

        if ($request->password !== $request->confirmPassword) {
            return response()->json(['message' => Constants::MISMATCH_PASSWORDS], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $user       = $this->userRepository->store($request->all());
            $verifyCode = rand(1000, 9999);

            $params = [
                'user_id'     => $user->id,
                'verify_code' => $verifyCode,
                'response'    => \App\Models\Registration::makeIncomeCall($user->phone, $verifyCode),
            ];

            (new \App\Repositories\RegistrationRepository)->store($params);

            return Response::jsonSuccess([
                'uuid'  => $user->uuid,
                'phone' => $user->phone,
            ],
                Response::HTTP_CREATED
            );
        } catch (Throwable $e) {
            $error = $e->errorInfo;

            // Dublicate entry error
            if ($error[1] == 1062) {
                return Response::jsonError($error[1], $error[2]);
            }
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
