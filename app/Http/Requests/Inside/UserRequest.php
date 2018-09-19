<?php

namespace App\Http\Requests\Shop;

use App\Http\Models\Inside\Staff;
use App\Http\Requests\Request;

class UserRequest extends Request
{

    public function __construct()
    {

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
//         $id = $this->input('staff_id');
// 		$staff = Staff::find(\Session::get('shop')->staff_id);
// 		$group = $staff->group;
// 		if($group == Staff::GROUP_OWNER){
// 			$data['email'] = 'required|unique:staff,email,' . $id;
// 			$data['group'] = ['required', 'in:' . implode(',', [Staff::GROUP_CASHIER, Staff::GROUP_SELLER, Staff::GROUP_OWNER])];
// 		}

        return $data;
    }

    public function messages()
    {
        $data = array();
        $data['email.required'] = 'Vui lòng nhập mã nhân viên.';
        $data['email.unique'] = 'Mã nhân viên đã tồn tại.';
        $data['group.required'] = 'Vui lòng chọn vị trí.';
        $data['group.in'] = 'Vị trí không hợp lệ.';

        return $data;
    }

}
