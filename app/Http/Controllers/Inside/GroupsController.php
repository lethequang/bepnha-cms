<?php

namespace App\Http\Controllers\Inside;

// use App\Http\Requests\Request;
use App\MyCore\Inside\Routing\MyController;
use App\Http\Models\Inside\StaffGroup;
use App\Http\Requests\Inside\StaffGroupsRequest;
use Symfony\Component\HttpKernel\Tests\HttpCache\StoreTest;
use Illuminate\Http\Request;

class GroupsController extends MyController {

    private $_model = null;
    private $_params = array();

    public function __construct() {
        $options = array();
        $this->_params = \Request::all();
        $this->data['params'] = $this->_params;
        parent::__construct($options);

        $this->data['title'] = 'Quản lý nhóm người dùng';
        $this->data['controllerName'] = 'groups';
        $this->_model = new StaffGroup();
    }

    /**
     * Enter description here ...
     * @return Ambigous <\Illuminate\Routing\Redirector, \Illuminate\Http\RedirectResponse>
     * @author HaLV
     */
    public function getIndex() {
        return redirect("/{$this->data['moduleName']}/{$this->data['controllerName']}/show-all");
    }

    /**
     * Enter description here ...
     * @return \Illuminate\View\View
     * @author HaLV
     */
    public function getShowAll() {
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
        ];

        $data = $this->_model->getAllStaffGroups($filter);

        return response()->json([
                'total' => $data['total'],
                'rows' => $data['data'],
                ]);
    }

    /**
     * Enter description here ...
     * @return \Illuminate\View\View
     * @author HaLV
     */
    public function getAdd() {
        return view("{$this->data['moduleName']}.{$this->data['controllerName']}.add", $this->buildDataView($this->data));
    }

    /**
     * Enter description here ...
     * @param StorageRequest $request
     * @return Ambigous <\Illuminate\Routing\Redirector, \Illuminate\Http\RedirectResponse>
     * @author HaLV
     */
    public function postAdd(LocationRequest $request) {

        $last_id = $this->_model->add($request);

        if ($last_id) {
            return redirect("/{$this->data['moduleName']}/{$this->data['controllerName']}/show-all");
        }

        return redirect("/{$this->data['moduleName']}/{$this->data['controllerName']}/add");
    }

    /**
     * Enter description here ...
     * @param unknown $id
     * @return \Illuminate\View\View
     * @author HaLV
     */
    public function getEdit($id) {
        $object = $this->_model->findOrNew($id)->toArray();

        $this->data['object'] = $object;

        return view("{$this->data['moduleName']}.{$this->data['controllerName']}.edit", $this->buildDataView($this->data));
    }

    /**
     * Enter description here ...
     * @param JobLevelsRequest $request
     * @param unknown $id
     * @return Ambigous <\Illuminate\Routing\Redirector, \Illuminate\Http\RedirectResponse>
     * @author HaLV
     */
    public function postEdit(LocationRequest $request, $id) {
        if ($this->_model->edit($request, $id)) {
            return redirect("/{$this->data['moduleName']}/{$this->data['controllerName']}/show-all");
        }
        return redirect("/{$this->data['moduleName']}/{$this->data['controllerName']}/edit", $id);
    }

     /**
      * Enter description here ...
      * @param unknown $id
      * @return Ambigous <\Illuminate\Routing\Redirector, \Illuminate\Http\RedirectResponse>
      * @author HaLV
      */
     public function getRemove($id) {
         if ($this->_model->remove($id)) {
             return redirect("/{$this->data['moduleName']}/{$this->data['controllerName']}/show-all");
         }
     }

    /**
     * Enter description here ...
     * @return Ambigous <\Illuminate\Routing\Redirector, \Illuminate\Http\RedirectResponse>
     * @author HaLV
     */
    public function postRemove() {
        if (isset($this->_params['ids'])) {
            $this->_model->removeMulti($this->_params['ids']);
            return response()->json(['msg' => 'Đổi trạng thái thành công!']);
        }
        return response()->json(['msg' => 'Đổi trạng thái không thành công!']);
    }
}
