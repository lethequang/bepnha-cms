<?php

namespace App\Http\Controllers\Inside;

use App\MyCore\Inside\Routing\MyController;
use App\Http\Models\Inside\NoteBook;
use DB;

class NoteBookController extends MyController
{
    private $_model = null;
    private $_params = array();

    public function __construct() {
        $options = array();
        $this->_params = \Request::all();
        $this->data['params'] = $this->_params;
        parent::__construct($options);

        $this->data['title'] = 'Quản lý sổ tay';
        $this->data['controllerName'] = 'notebook';
        $this->_model = new Notebook();
    }

    public function getShowAll() {
        return 'show all';
        //$this->data['status'] = ['' => ''] + $this->_model->getOptionsStatus();
        //return view("{$this->data['moduleName']}.{$this->data['controllerName']}.show-all", $this->buildDataView($this->data));
    }

    public function getAjaxData(Request $request)
    {
        $filter = [
            'offset' => $request->input('offset', 0),
            'limit' => $request->input('limit', PAGE_LIST_COUNT),
            'sort' => $request->input('sort', 'id'),
            'order' => $request->input('order', 'asc'),
            'search' => $request->input('search', ''),
            'status' => $request->input('status', ''),
            'from' => $request->input('from', ''),
            'to' => $request->input('to', '')
        ];

        $data = $this->_model->getAllTags($filter);

        return response()->json([
            'total' => $data['total'],
            'rows' => $data['data']
        ]);
    }
    public function getAdd() {
        $this->data['notebook'] = DB::select('select id, title from tags');
        $data = $this->buildDataView($this->data);
        return view("{$this->data['moduleName']}.{$this->data['controllerName']}.add", $data);
    }
    public function postAdd(Request $request) {

        $last_id = $this->_model->add($request);

        if ($last_id) {
            return redirect("/{$this->data['moduleName']}/{$this->data['controllerName']}/show-all");
        }

        return redirect("/{$this->data['moduleName']}/{$this->data['controllerName']}/add");
    }
    public function getEdit($id) {
        $object = $this->_model->findOrNew($id)->toArray();

        $ctags = DB::select('select tag_id from tag_grouped where tag_group_id=?', [$id]);
        $tags = $this->toKeyPairs('id', DB::select('select id, title from tags'));
        foreach ($ctags as $v) {
            $k = $v->tag_id;
            if(isset($tags[$k])) {
                $tags[$k]->checked = true;
            }
        }

        $object['tags'] = $tags;

        $this->data['object'] = $object;

        return view("{$this->data['moduleName']}.{$this->data['controllerName']}.edit", $this->buildDataView($this->data));
    }

    public function postEdit(Request $request, $id) {
        if ($this->_model->edit($request, $id)) {
            return redirect("/{$this->data['moduleName']}/{$this->data['controllerName']}/show-all");
        }
        return redirect("/{$this->data['moduleName']}/{$this->data['controllerName']}/edit", $id);
    }

    public function getRemove($id) {
        if ($this->_model->remove($id)) {
            return redirect("/{$this->data['moduleName']}/{$this->data['controllerName']}/show-all");
        }
    }

    public function postRemove() {
        if (isset($this->_params['ids'])) {
            $this->_model->removeMulti($this->_params['ids']);
            return response()->json(['msg' => 'Đổi trạng thái thành công!']);
        }
        return response()->json(['msg' => 'Đổi trạng thái không thành công!']);
    }
}