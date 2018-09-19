<?php

namespace App\Http\Controllers\Inside;

use App\MyCore\Inside\Routing\MyController;
use View;
use App\Http\Requests\Inside\UserLoginRequest;
//use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Hash, Auth;
use App\Http\Models\Inside\Staff;
use Illuminate\Http\Request;
use App\Http\Requests\Inside\ChangePasswordRequest;

class UsersController extends MyController {

    private $_model = null;
    private $_params = array();

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    public function __construct() {
        $options = array();
        $this->_params = \Request::all();
        $this->data['params'] = $this->_params;
        parent::__construct($options);

        $this->data['title'] = 'User';
        $this->data['controllerName'] = 'users';
    }

    /**
     * Enter description here ...
     * @return Ambigous <\Illuminate\Routing\Redirector, \Illuminate\Http\RedirectResponse>
     * @author HaLV
     */
    public function getIndex() {
        return redirect("/{$this->data['moduleName']}/{$this->data['controllerName']}/dashboard");
    }

    public function getDashboard() {
        $this->data['title'] = 'Dashboard';
        return view("{$this->data['moduleName']}/{$this->data['controllerName']}.dashboard", $this->buildDataView($this->data));
    }

    /**
     * Enter description here ...
     * @return \Illuminate\View\View
     * @author HaLV
     */
    public function getLogin() {
        return view("{$this->data['moduleName']}/{$this->data['controllerName']}.login", $this->buildDataView($this->data));
    }

    /**
     * Enter description here ...
     * @param UserLoginRequest $request
     * @author HaLV
     */
    public function postLogin(UserLoginRequest $request) {
        $auth = array(
            'email'      => $request->email,
            'password'   => $request->password,
            'disable'    => 0
        );
        $isRemember = (isset($request->is_remember_me) && $request->is_remember_me == 1) ? true : false;
        if (Auth::attempt($auth, $isRemember)) {
            return redirect("{$this->data['moduleName']}/{$this->data['controllerName']}/dashboard");
        }
        return redirect("{$this->data['moduleName']}/{$this->data['controllerName']}/login")->with('message', 'Email hoặc password không chính xác!')->withInput();
    }

    public function getLogout() {
        Auth::logout();
        return redirect("{$this->data['moduleName']}/{$this->data['controllerName']}/login");
    }


	/**
     * Enter description here ...
     * @param
     * @author Long Nguyen
     */

    public function getProfile() {
		$this->data['title'] = 'Thông tin tài khoản';
		$userId = $this->data['user']->id;
		$this->data['objectStaff'] = Staff::find($userId);

		$this->data['groups'] = ['' => '------'] + Staff::listStaffGroupWithLabel([Staff::GROUP_SUPER_ADMIN, Staff::GROUP_ADMIN]);
		$this->data['pageTitle'] = 'Cập nhật thông tin';
		$this->data['forceEdit'] = true;
        return view("{$this->data['moduleName']}/{$this->data['controllerName']}.profile", $this->buildDataView($this->data));
    }

	 /**
     * Edit staff request
     * @param Request UserRequest
     * @param unknown $id
     * @return Ambigous <\Illuminate\Routing\Redirector, \Illuminate\Http\RedirectResponse>
     * @author Long Nguyen <vulong.it90@gmail.com>
     */
    public function postProfile(Request $request)
    {
		$id = $request->input('staff_id');
		$userId = $this->data['user']->id;
		$model = new Staff;
		$msg = ['status' => 'warning', 'value' => 'Không thể cập nhật'];
		if($id == $userId){
			if ($model->editUserProfile($request, $id)) {
				$msg =  ['status' => 'success', 'value' => 'Chỉnh sửa thành công!'];
			}
		}
		$this->data['objectStaff'] = Staff::find($userId);
        return redirect("/{$this->data['moduleName']}/{$this->data['controllerName']}/profile")
			->with('msg', $msg);
    }

	/**
     * reset password request
     * @return JSON
     * @author Long Nguyen <vulong.it90@gmail.com>
     */
    public function postChangePassword(ChangePasswordRequest $request)
    {
		$userId = $this->data['user']->id;
        $id = $request->input('staff_id');
        $model = Staff::where('id', $id)->first();
        $model->password = bcrypt($request->input('password'));
		if($id == $userId){
			if ($model->save()) {
				return response()->json(['msg' => 'Cập nhật thành công!']);
			}
		}
        return response()->json(['msg' => 'Lỗi cập nhật!']);
    }
}