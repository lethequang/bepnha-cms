<?php

namespace App\Http\Requests\Inside;

use App\Http\Models\Inside\Staff;
use App\Http\Models\Inside\StaffGroup;
use App\Http\Requests\Request;

class StaffRequest extends Request
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
        $id = $this->input('staff_id');
        $data['email'] = 'required|unique:staff,email,' . $id;
        $data['password'] = 'required';
        $data['group'] = ['required', 'in:' . implode(',', Staff::listStaffGroup())];
        if (!empty($id)) {
            $data = [];
        }

        return $data;
    }

    public function messages()
    {
        $data = array();
        $data['email.required'] = 'Vui lòng nhập Email.';
        $data['email.unique'] = 'Mã nhân viên đã tồn tại.';
        $data['password.required'] = 'Vui lòng nhập mật khẩu.';
        $data['group.required'] = 'Vui lòng chọn Group.';
        $data['group.in'] = 'Vị trí không hợp lệ.';

        return $data;
    }

}
