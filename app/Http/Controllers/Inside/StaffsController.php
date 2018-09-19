<?php

namespace App\Http\Controllers\Inside;

use App\Http\Models\Inside\Staff;
use App\Http\Models\Inside\StaffGroup;
use App\Http\Requests\Inside\StaffRequest;
use App\Http\Requests\Inside\ResetPasswordRequest;
use App\MyCore\Inside\Routing\MyController;
use Illuminate\Http\Request;

class StaffsController extends MyController
{

    public function __construct()
    {
        $options = array();
        $this->_params = \Request::all();
        $this->data['params'] = $this->_params;
        parent::__construct($options);

        $this->data['title'] = 'Quản lý nhân sự';
        $this->data['controllerName'] = 'staffs';
        $this->_model = new Staff();
//         if (!$this->data['manageStaff']) {
//             abort(403, 'Forbidden');
//         }
    }

    /**
     * Staff page
     * @return Ambigous <\Illuminate\Routing\Redirector, \Illuminate\Http\RedirectResponse>
     * @author HaLV
     */
    public function getIndex()
    {
        return redirect("/{$this->data['moduleName']}/{$this->data['controllerName']}/show-all");
    }

    /**
     * List staffs page
     * @return \Illuminate\View\View
     * @author HaLV
     */
    public function getShowAll()
    {
        $this->data['groups'] = ['' => '-- lọc theo group --'] + Staff::listStaffGroupWithLabel();
        $this->data['status'] = ['' => '-- lọc theo trạng thái --'] + $this->_model->getOptionsStatus();
        return view("{$this->data['moduleName']}.{$this->data['controllerName']}.show-all", $this->buildDataView($this->data));
    }

    /**
     * List staffs request
     * @return JSON
     * @author HaLV
     */
    public function getAjaxData(Request $request)
    {
        $filter = [
            'offset' => $request->input('offset', 0),
            'limit' => $request->input('limit', PAGE_LIST_COUNT),
            'sort' => $request->input('sort', 'id'),
            'order' => $request->input('order', 'asc'),
            'search' => $request->input('search', ''),
            'group' => $request->input('group', ''),
            'status' => $request->input('status', ''),
        ];

        $data = $this->_model->listStaff($filter);

        return response()->json([
            'total' => $data['total'],
            'rows' => $data['data']
        ]);
    }

    /**
     * Add staff page
     * @return \Illuminate\View\View
     * @author HaLV
     */
    public function getAdd()
    {
    	$this->data['object'] = new Staff;
        $this->data['groups'] = ['' => '----- Chọn Group -----'] + Staff::listStaffGroupWithLabel();
        $this->data['pageTitle'] = 'Thêm mới';

        return view("{$this->data['moduleName']}.{$this->data['controllerName']}.add", $this->buildDataView($this->data));
    }

    /**
     * Add staff request
     * @return Ambigous <\Illuminate\Routing\Redirector, \Illuminate\Http\RedirectResponse>
     * @author HaLV
     */
    public function postAdd(StaffRequest $request)
    {
        if ($this->_model->addStaff($request)) {
            return redirect("/{$this->data['moduleName']}/{$this->data['controllerName']}/show-all")
                    ->with('msg', 'Thêm mới thành công!');;
        }
        return redirect("/{$this->data['moduleName']}/{$this->data['controllerName']}/add");
    }

    /**
     * Edit staff page
     * @param unknown $id
     * @return Ambigous <\Illuminate\Routing\Redirector, \Illuminate\Http\RedirectResponse>
     * @author HaLV
     */
    public function getEdit($id)
    {
        $this->data['object'] = $this->_model->findOrNew($id);
        $this->data['groups'] = ['' => '------'] + Staff::listStaffGroupWithLabel();
        $this->data['pageTitle'] = 'Chỉnh sửa';

        return view("{$this->data['moduleName']}.{$this->data['controllerName']}.edit", $this->buildDataView($this->data));
    }

    /**
     * Edit staff request
     * @param Request ProductPriceRequest
     * @param unknown $id
     * @return Ambigous <\Illuminate\Routing\Redirector, \Illuminate\Http\RedirectResponse>
     * @author HaLV
     */
    public function postEdit(StaffRequest $request, $id)
    {
        if ($this->_model->edit($request, $id)) {
            return redirect("/{$this->data['moduleName']}/{$this->data['controllerName']}/show-all")
                    ->with('msg', 'Cập nhật thành công!');
        }
        return redirect("/{$this->data['moduleName']}/{$this->data['controllerName']}/edit", $id);
    }

    /**
     * Remove staffs request
     * @return JSON
     * @author HaLV
     */
    public function postRemove()
    {
        if (isset($this->_params['ids'])) {
            $this->_model->removeMultiStaff($this->_params['ids']);
            return response()->json(['msg' => 'Cập nhật thành công!']);
        }
        return response()->json(['msg' => 'Lỗi cập nhật!']);
    }

    /**
     * reset password request
     * @return JSON
     * @author HaLV
     */
    public function postResetPassword(ResetPasswordRequest $request)
    {
        $id = $request->input('staff_id');
        $model = Staff::where('id', $id)->first();
        $model->password = bcrypt($request->input('password'));
        if ($model->save()) {
            return response()->json(['msg' => 'Cập nhật thành công!']);
        }
        return response()->json(['msg' => 'Lỗi cập nhật!']);
    }
}
