<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Response;
use Exception;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use App\Traits\ApiResponser;

class Handler extends ExceptionHandler
{
    use ApiResponser;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
        $this->renderable(function(TokenInvalidException $e, $request){
            // return Response::json(['error'=>'Invalid token'],401);
            return $this->errorResponse([],'Invalid token',401 );

        });
        $this->renderable(function (TokenExpiredException $e, $request) {
            // return Response::json(['error'=>'Token has Expired'],401);

            return $this->errorResponse([],'Token has Expired',401 );

        });

        $this->renderable(function (JWTException $e, $request) {

            // return Response::json(['error'=>'Token not parsed'],401);
            return $this->errorResponse([],'Token not parsed',401 );

        });
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
