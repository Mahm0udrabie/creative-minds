<?php
namespace App\Traits;

use Illuminate\Http\Exceptions\HttpResponseException;


trait ApiResponser{

    protected function successResponse($data = [], $message = "", $code = 200)
	{
		return response()->json([
			'status'=> $code,
			'message' => $message,
			'data' => $data
		], $code);
	}

	protected function errorResponse($data = [], $message , $code = 422)
	{
		if(!is_string($message) && count($message) > 0) {
			$msg = $message->first();
		} else{
			$msg = $message;
		}
       throw new  HttpResponseException(
		 response()->json([
			'status'=> $code ,
			'message' => $msg,
		], $code));
	}

}
