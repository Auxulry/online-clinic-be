<?php

namespace App\Exceptions;

use App\Traits\ApiResponserTrait;
use ErrorException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ApiResponserTrait;
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function render($request, Throwable $e)
    {
        if ($request->is('api/*')) {
            if ($e instanceof NotFoundHttpException) {
                return $this->errorResponse(
                    Response::HTTP_NOT_FOUND,
                    $e->getMessage(),
                );
            } elseif ($e instanceof MethodNotAllowedHttpException) {
                return $this->errorResponse(
                    Response::HTTP_METHOD_NOT_ALLOWED,
                    $e->getMessage()
                );
            } elseif ($e instanceof BadRequestHttpException) {
                $responseData = json_decode($e->getMessage(), true);
                $message = $responseData['message'] ?? 'Bad Request';
                $errors = $responseData['errors'] ?? [];
                return $this->errorResponse(
                    Response::HTTP_BAD_REQUEST,
                    $message,
                    $errors
                );
            } elseif ($e instanceof UnprocessableEntityHttpException) {
                return $this->errorResponse(
                    Response::HTTP_UNPROCESSABLE_ENTITY,
                    $e->getMessage(),
                );
            } else if ($e instanceof AuthenticationException && $e->getMessage() === 'Unauthenticated.' || $e instanceof AuthorizationException) {
                return $this->errorResponse(
                    Response::HTTP_UNAUTHORIZED,
                    $e->getMessage()
                );
            } else {
                return $this->errorResponse(
                    Response::HTTP_INTERNAL_SERVER_ERROR,
                    config('app.env') != 'local' ? 'Something wrong' : $e->getMessage()
                );
            }
        }

        return parent::render($request, $e);
    }

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
