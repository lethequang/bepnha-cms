<?php namespace App\Http\Requests\Inside;

use App\Http\Requests\Request;

class UserLoginRequest extends Request {
    
    public function __construct() {
    }
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        $data = array();
        $data["email"] = 'required';
        $data["password"] = 'required';
        return $data;
    }

    public function messages () {
        $data = array();
        $data["email.required"] = 'Vui lòng nhập email';
        $data["password.required"] = 'Vui lòng nhập mật khẩu';
        return $data;
    }
}