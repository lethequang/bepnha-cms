<?php

namespace App\Http\Requests\Inside;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Routing\Route;
use App\Http\Models\Inside\Staff;
use Hash;
class ChangePasswordRequest extends Request
{

    public function __construct()
    {
		Validator::extend('old_password', function($attribute, $value, $parameters)
		{
			return Hash::check($value, current($parameters));
		});
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $data = array();

		if(null !== $this->input('type') && $this->input('type') == 'shop'){
			$model = Staff::where('id', $this->input('staff_storage_id'))->first();
			if(!empty($model)){
				$data['old_password'] = 'required|old_password:' . $model->password;
			}
			else{
				$data['old_password'] = 'required|old_password:-1';
			}
		}else{
			$data['old_password'] = 'required|old_password:' . Auth::user()->password;
		}
        $data['password'] = 'required|confirmed';
        $data['password_confirmation'] = 'required';

        return $data;
    }

    public function messages()
    {
        $data['old_password.required'] = 'Vui lòng nhập mật khẩu cũ.';
        $data['old_password.old_password'] = 'Mật khẩu cũ không đúng.';
        $data['password.required'] = 'Vui lòng nhập mật khẩu mới.';
        $data['password.confirmed'] = 'Mật khẩu không khớp.';
        $data['password_confirmation.required'] = 'Vui lòng nhập lại mật khẩu mới.';

        return $data;
    }

}
