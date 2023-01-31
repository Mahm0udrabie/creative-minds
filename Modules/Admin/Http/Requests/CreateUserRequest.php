<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Traits\ApiResponser;

class CreateUserRequest extends FormRequest
{
    use ApiResponser;
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'username'=> 'required|string|unique:users,username',
            'email' => 'required|string|email|unique:users',
            'phone' => 'required|numeric|phone_number|regex:/(01)[0-9]{9}/|unique:users,phone',
            'password' => 'required|string|min:8'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    protected function failedValidation(Validator $validator)
    {
        return $this->errorResponse( [],$validator->errors(), 422 );
    }
}
