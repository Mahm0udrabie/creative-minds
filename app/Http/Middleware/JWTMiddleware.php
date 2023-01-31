<?php
namespace App\Http\Middleware;
use Closure;
// use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use App\Traits\ApiResponser;
use Tymon\JWTAuth\Facades\JWTAuth;

class JWTMiddleware extends BaseMiddleware
{
    use ApiResponser;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
          $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                // return response()->json(['status' => 'Token is Invalid']);
                return $this->errorResponse([],  'Token is Invalid', 401);
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                // return response()->json(['status' => 'Token is Expired']);
                return $this->errorResponse([],  'Token is Expired', 401);

            }else{
                // return response()->json(['status' => 'Authorization Token not found']);
                return $this->errorResponse([],  'Token is Expired', 401);
            }
        }
        return $next($request);
    }
}
