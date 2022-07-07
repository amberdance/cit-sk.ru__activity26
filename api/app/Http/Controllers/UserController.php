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

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function registration(Request $request): JsonResponse
    {

        $request->validate([
            'name'     => 'required',
            'surname'  => 'required',
            'email'    => 'required|email',
            'password' => 'required',
            'phone'    => ['required', 'regex:/(\+7)[- _]*\(?[- _]*(\d{3}[- _]*\)?([- _]*\d){7}|\d\d[- _]*\d\d[- _]*\)?([- _]*\d){6})/'],
        ]);

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
