<?php

namespace App\Http\Controllers;

use App\Http\Response;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function registation(Request $request)
    {

        $request->validate([
            'phone' => ['required', 'regex:/(\+7)[- _]*\(?[- _]*(\d{3}[- _]*\)?([- _]*\d){7}|\d\d[- _]*\d\d[- _]*\)?([- _]*\d){6})/'],
            'phone' => 'required',
            'login' => 'required|email',
        ]);

        $payload             = $request->all();
        $payload["password"] = Hash::make($request->password);

        $user = $this->userRepository->createUser($payload);

        return Response::jsonSuccess(
            [
                'token' => $user->token,
            ],

            Response::HTTP_CREATED
        );
    }
}
