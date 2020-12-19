<?php

namespace App\Exceptions;

use App\Traits\RespondsWithHttpStatus;
use App\Utils\ResponseMessage;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class Handler extends ExceptionHandler
{
    use RespondsWithHttpStatus;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof ModelNotFoundException) {
            return $this->apiResponse(
                ResponseMessage::NOT_FOUND,
                null,
                Response::HTTP_NOT_FOUND,
                false
            );
        } else if ($exception instanceof NotFoundHttpException) {
            return $this->apiResponse(
                ResponseMessage::NOT_FOUND,
                null,
                Response::HTTP_NOT_FOUND,
                false
            );
        } else if ($exception instanceof MethodNotAllowedHttpException) {
            return $this->apiResponse(
                ResponseMessage::METHOD_NOT_ALLOWED,
                null,
                Response::HTTP_METHOD_NOT_ALLOWED,
                false
            );
        } else if ($exception instanceof HttpException) {
            return $this->apiResponse(
                ResponseMessage::NOT_FOUND,
                null,
                Response::HTTP_NOT_FOUND,
                false
            );
        } else if ($exception instanceof UnauthorizedException) {
            return $this->apiResponse(
                ResponseMessage::UNAUTHORIZED,
                null,
                Response::HTTP_UNAUTHORIZED,
                false
            );
        } else if ($exception instanceof UnauthorizedHttpException) {
            return $this->apiResponse(
                ResponseMessage::UNAUTHORIZED,
                null,
                Response::HTTP_UNAUTHORIZED,
                false
            );
        } else if ($exception instanceof AuthenticationException) {
            return $this->apiResponse(
                ResponseMessage::UNAUTHENTICATED,
                null,
                Response::HTTP_UNAUTHORIZED,
                false
            );
        } else {
            Log::error("Exceptions", [
                'error' => $exception->getMessage()
            ]);
            return $this->apiResponse(
                ResponseMessage::SERVER_ERROR,
                null,
                Response::HTTP_INTERNAL_SERVER_ERROR,
                false
            );
        }
    }
}
