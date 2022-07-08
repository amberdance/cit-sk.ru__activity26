<?php

namespace App\Http\Controllers;

use App\Http\Response;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class UserController extends Controller
{

    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getUser(int $id)
    {
        return Response::jsonSuccess($this->userRepository->getUserById($id));
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function registration(Request $request): JsonResponse
    {

        $request->validate([
            'name'            => 'required',
            'surname'         => 'required',
            'email'           => 'required|email',
            'confirmPassword' => 'required',
            'password'        => ['required', 'regex:/^(?=(.*[a-z]){3,})(?=(.*[A-Z]){2,})(?=(.*[0-9]){1,})(?=(.*[!@#$%^&*()\-__+.]){1,}).{8,}$/'],
            'phone'           => ['required', 'regex:/^(\+7[\- ]?)?(\([9]{1}\d{2}\)?[\- ]?)?[\d\- ]{5,10}$/'],
        ]);

        if ($request->password !== $request->confirmPassword) {
            return response()->json(['message' => 'Passwords is not match'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $user = $this->userRepository->createUser($request->all());

            return Response::jsonSuccess(['uuid' => $user->uuid], Response::HTTP_CREATED);
        } catch (Throwable | ModelNotFoundException $e) {
            $error = $e->errorInfo;

            // Dublicate entry error
            if ($error[1] == 1062) {
                return Response::jsonError(1062, $error[2], Response::HTTP_OK);
            }

            return Response::jsonError($e[1], $error[2], Response::HTTP_OK);
        }
    }
}
