<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use App\Http\Requests\RegisterRequest;
use App\Repositories\UserRepositoryInterface;
use App\Http\Requests\VerifyPhoneNumberRequest;
use App\Services\TwilioService;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    use ApiResponser;
    protected $user;

    public function __construct(UserRepositoryInterface $user) {
        $this->user   = $user;
    }

    public function register(RegisterRequest $request) {

        $data = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password)
        ];

        TwilioService::sendVerificationCode($request);

        $this->user->store($data);

        return $this->successResponse([], "please verify your phone number", 200);
    }

    public function verify(VerifyPhoneNumberRequest $request) {

        $check =  TwilioService::checkVerificationCode($request);

        if (optional($check)->valid) {

            $this->user->setIsVerifiedTrue($request->phone, ['isVerified'=> true]);

            return $this->successResponse([], "Verified Successfully", 200);

        } else {

            return $this->errorResponse([], "Verification code is invalid", 401);
        }
    }

    public function resend(Request $request) {

        return TwilioService::sendVerificationCode($request);

    }

    public function login(LoginRequest $request) {

        $credentials = $request->only('phone', 'password');
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return $this->errorResponse([], "Login credentials are invalid.", 401);
            }
        } catch (JWTException $e) {
            return $this->errorResponse([], "Could not create token.", 500);
        }
        return $this->successResponse(["token" => $token], "Logged in successfully", 200);
    }

    public function logout()
    {
        auth()->logout();
        return $this->successResponse([], "You have been successfully logged out!", 200);
    }
}
