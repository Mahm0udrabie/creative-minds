<?php

namespace App\Services;

use App\Traits\ApiResponser;
use Twilio\Rest\Client;

class TwilioService {
    use ApiResponser;

    public function sendVerificationCode($data) { // send verification code
        try {
            $twilio = new Client(getenv('TWILIO_ACCOUNT_SID'), getenv('TWILIO_AUTH_TOKEN'));
            $twilio->verify->v2->services(getenv('TWILIO_VERIFY_SID'))
            ->verifications->create($data['phone'], "sms");
        } catch (\Throwable $th) {
            return self::errorResponse([], $th->getMessage(), $th->getStatusCode());
        }
    }
    public function checkVerificationCode($request) {
        $phone =$request->phone;
        $code = $request->verification_code;
        if($code) {
        try {
            $twilio = new Client(getenv('TWILIO_ACCOUNT_SID'), getenv('TWILIO_AUTH_TOKEN'));
            return $twilio->verify->v2->services(getenv('TWILIO_VERIFY_SID'))
                ->verificationChecks
                ->create(['code' => $code, 'to' => $phone]);
            } catch (\Throwable $th) {
                     return self::errorResponse([],$th->getMessage(), 404);
            }
        }
    }


}

?>
