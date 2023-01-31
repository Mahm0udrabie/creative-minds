<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use Illuminate\Auth\AuthenticationException;
use App\Models\User;

class PhoneVerified
{
    use ApiResponser;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $isUserPhoneNumberVerified = optional(User::where('phone', $request->phone)->first())->isVerified;
        if(!$isUserPhoneNumberVerified) {
            return $this->errorResponse([], 'Phone number is not verified', 422);
        }
        return $next($request);
    }
}
