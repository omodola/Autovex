<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
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
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e): Response|JsonResponse|\Symfony\Component\HttpFoundation\Response
    {
        if($request->wantsJson()){

            $message = $e->getMessage();
            try{
                $statusCode = $e->getStatusCode();
            }catch (Throwable $throwable){
                $statusCode = 400;
            }

            // This will replace 404 response with a JSON response.
            if ($e instanceof NotFoundHttpException)
            {
                $message = $message ?? '404 | Not found';
            }

            if($e instanceof AuthenticationException){
                $statusCode = 401;
            }

            return response()->json([
                'error' => $message,
                'code'  => $statusCode,
                'data'  => []
            ], $statusCode);
        }
        return parent::render($request, $e);
    }
}
