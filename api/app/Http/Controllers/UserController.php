<?php

namespace App\Http\Controllers;

use App\Http\Response;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{

    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function store(Request $request): JsonResponse
    {

        $request->validate([
            'phone' => ['required', 'regex:/(\+7)[- _]*\(?[- _]*(\d{3}[- _]*\)?([- _]*\d){7}|\d\d[- _]*\d\d[- _]*\)?([- _]*\d){6})/'],
        ]);

        $user = $this->userRepository->createUser($request->all());

        return Response::jsonSuccess(
            [
                'token' => $user->token,
            ],
            Response::HTTP_CREATED
        );
    }
}
