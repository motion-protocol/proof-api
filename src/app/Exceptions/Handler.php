<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use ProofRegistry\Application\Movie\Exceptions\MovieAlreadyAddedException;

class Handler extends ExceptionHandler
{
    const STATUS_CODES = [
        MovieAlreadyAddedException::class => 400,
    ];
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
        $statusCode = self::STATUS_CODES[get_class($exception)] ?? null;
        if ($statusCode) {
            return response()->json(['error' => $exception->getMessage()])->setStatusCode($statusCode);
        }
        return parent::render($request, $exception);
    }
}
