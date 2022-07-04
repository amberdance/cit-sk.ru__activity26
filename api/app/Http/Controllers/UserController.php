<?php

namespace App\Http\Controllers;

use App\Http\Response;
use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function store(Request $request)
    {

        $request->validate([
            'phone' => ['required', 'regex:/(\+7)[- _]*\(?[- _]*(\d{3}[- _]*\)?([- _]*\d){7}|\d\d[- _]*\d\d[- _]*\)?([- _]*\d){6})/'],
            'phone' => 'required',
            'email' => 'required|email',
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

    public function login(Request $request)
    {

        $request->validate([
            "login"    => "required|email",
            "password" => "required",
        ]);

        $user = User::where("email", $request->login)->first();

        $isAuthorized = Auth::attempt([
            'email'    => $request->login,
            'password' => $request->password,
        ]);

        if (!$isAuthorized) {
            return Response::HTTP_UNAUTHORIZED;
        }

        return Response::jsonSuccess([
            'token' => $request->user()->createToken('API Token')->plainTextToken,
        ]);
    }

    /**
     * @param Request $request
     *
     * @return int
     */
    public function logout(Request $request): int
    {
        $request->user()->tokens()->delete();

        return Response::HTTP_OK;
    }
}
