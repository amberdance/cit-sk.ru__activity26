<?php

namespace App\Exceptions;

use App\Http\Constants;
use App\Http\Response;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * @param mixed $request
     * @param Throwable $e
     *
     * @return mixed
     */
    public function render($request, Throwable $e): mixed
    {

        if ($e instanceof NotFoundHttpException || $e instanceof ModelNotFoundException) {
            return Response::jsonError(404, Constants::NOT_FOUND_MESSAGE, Response::HTTP_NOT_FOUND);
        }

        if ($e instanceof AuthenticationException) {
            return Response::jsonError(401, Constants::USER_UNAUTHENTICATED_MESSAGE, Response::HTTP_OK);
        }

        return parent::render($request, $e);
    }
}
