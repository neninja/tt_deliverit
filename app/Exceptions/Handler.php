<?php

namespace App\Exceptions;

use Illuminate\Support\Facades\App;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

use Core\Exceptions\CoreException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        // parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $e)
    {
        // return parent::render($request, $e);

        $response = [
            'message' => "Erro interno",
        ];

        if (App::environment('local') || App::environment('testing')) {
            $response['message'] = $e->getMessage();
            $response['file'] = $e->getFile();
            $response['line'] = $e->getLine();
        }

        if ($e instanceof CoreException) {
            $response['message'] = $e->getMessage();
            return $this->jsonResponse($response, 400);
        }

        return $this->jsonResponse($response, 500);
    }

    protected function jsonResponse($body, $code)
    {
        return response()->json(
            $body,
            $code,
            ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_UNESCAPED_UNICODE
        );
    }
}
