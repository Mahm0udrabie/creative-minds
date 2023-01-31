<?php

namespace Modules\Admin\Http\Controllers\Auth;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Admin\Http\Requests\LoginRequest;
use Modules\Admin\Entities\Admin;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Traits\ApiResponser;

class AuthAdminController extends Controller
{
    use ApiResponser;

    public function login(LoginRequest $request)
    {
        auth()->shouldUse('admin');
        $credentials = $request->only('email', 'password');
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return $this->errorResponse([],'Login credentials are invalid.', 400);
            }
        } catch (JWTException $e) {
            return $this->errorResponse([], 'Could not create token.', 422);
        }
         return $this->successResponse(['token' => $token], 'Logged In Successfully.', 200);
    }
    public function logout() {
        auth()->shouldUse('admin');
        auth()->logout();
        return $this->successResponse([], "You have been successfully logged out!", 200);
    }
}
