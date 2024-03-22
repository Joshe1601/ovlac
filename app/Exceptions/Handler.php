<?php
namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Throwable;

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
     * @param  \Exception  $e
     * @return void
     */
    public function report(Throwable $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $e)
    {
        $response = [ 
            'type' => get_class($e),
            'code' => $e->getCode(),
            'message' => $e->getMessage(),
            'data' => [
                'status' => 500
            ]
        ];

        if ($e instanceof ModelNotFoundException) {
            $response['data']['status'] = 404;
        }

        if ($e instanceof HttpException) {
            $response['data']['status'] = $e->getStatusCode();
        }

        if (config('app.debug')) {
            $response['line'] = $e->getLine();
            $response['file'] = $e->getFile();
            $response['trace'] = $e->getTraceAsString();
        }

        return response()->json($response, $response['data']['status']);
    }
}