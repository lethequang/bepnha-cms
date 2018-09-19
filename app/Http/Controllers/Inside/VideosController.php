<?php

namespace App\Http\Controllers\Inside;

use App\MyCore\Inside\Routing\MyController;
use App\Http\Models\Inside\Videos;
use App\Http\Models\Inside\VideoTypes;
use App\Http\Models\Inside\Categories;
use App\Http\Models\Inside\Levels;
use App\Http\Requests\Inside\VideosRequest;
use DB;
use Illuminate\Http\Request;

use Excel;

class VideosController extends MyController {

    private $_model = null;
    private $_params = array();

    public function __construct() {
        $options = array();
        $this->_params = \Request::all();
        $this->data['params'] = $this->_params;
        parent::__construct($options);

        $this->data['title'] = 'Quản lý Video';
        $this->data['controllerName'] = 'videos';
        $this->_model = new Videos();
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
        $this->data['filters'] = session('video_filters', [
            'offset' => 0,
            'limit' => PAGE_LIST_COUNT,
            'sort' => 'id',
            'order' => 'asc',
            'search' => '',
            'status' => 'active',
            'from' => '',
            'to' => '',
            'pcategory' => '',
            'category' => '',
        ]);
        $this->data['status'] = ['' => '- lọc theo trạng thái -'] + $this->_model->getOptionsStatus();
        $this->data['pcategories'] = ['' => '- lọc theo danh mục chính -'] + Categories::getOptionsCategoryByType(1);
        $this->data['categories'] = ['' => '- lọc theo danh mục phụ -'] + Categories::getOptionsCategoryByType(2);
        return view("{$this->data['moduleName']}.{$this->data['controllerName']}.show-all", $this->buildDataView($this->data));
    }

    /**
     * Enter description here ...
     * @return \Illuminate\View\View
     * @author HaLV
     */
    public function getListFeatured() {
        $this->data['status'] = ['' => ''] + $this->_model->getOptionsStatus();
        $this->data['categories'] = ['' => ''] + Categories::getOptionsCategory();
        return view("{$this->data['moduleName']}.{$this->data['controllerName']}.list-featured", $this->buildDataView($this->data));
    }

    /**
     * Enter description here ...
     * @return \Illuminate\View\View
     * @author HaLV
     */
    public function getListRecipe() {
        $this->data['status'] = ['' => ''] + $this->_model->getOptionsStatus();
        $this->data['categories'] = ['' => ''] + Categories::getOptionsCategory();
        return view("{$this->data['moduleName']}.{$this->data['controllerName']}.list-recipe", $this->buildDataView($this->data));
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
            'status' => $request->input('status', ''),
            'from' => $request->input('from', ''),
            'to' => $request->input('to', ''),
            'pcategory' => $request->input('pcategory', ''),
            'category' => $request->input('category', ''),
        ];
        session('video_filters', $filter);

        $data = $this->_model->getAllVideos($filter);

        return response()->json([
            'total' => $data['total'],
            'rows' => $data['data'],
        ]);
    }

    /**
     * List staffs request
     * @return JSON
     * @author HaLV
     */
    public function getAjaxDataFeatured(Request $request)
    {
        $filter = [
            'offset' => $request->input('offset', 0),
            'limit' => $request->input('limit', PAGE_LIST_COUNT),
            'sort' => $request->input('sort', 'ordering'),
            'order' => $request->input('order', 'asc'),
            'search' => $request->input('search', ''),
            'status' => $request->input('status', ''),
            'from' => $request->input('from', ''),
            'category' => $request->input('category', ''),
            'to' => $request->input('to', ''),
        ];

        $data = $this->_model->getFeaturedVideos($filter);

        return response()->json([
                'total' => $data['total'],
                'rows' => $data['data'],
                ]);
    }

    /**
     * List staffs request
     * @return JSON
     * @author HaLV
     */
    public function getAjaxDataRecipe(Request $request)
    {
        $filter = [
        'offset' => $request->input('offset', 0),
        'limit' => $request->input('limit', PAGE_LIST_COUNT),
        'sort' => $request->input('sort', 'id'),
        'order' => $request->input('order', 'asc'),
        'search' => $request->input('search', ''),
        'status' => $request->input('status', ''),
        'from' => $request->input('from', ''),
        'category' => $request->input('category', ''),
        'to' => $request->input('to', ''),
        ];

        $data = $this->_model->getRecipeVideos($filter);

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
        $this->data['pcategories'] = array('' => '----- Chọn Category chính -----') + Categories::getOptionsCategoryByType(1);
        $this->data['categories'] = array('' => '----- Chọn Category phụ -----') + Categories::getOptionsCategoryByType(2);
        $this->data['types'] = array('' => '----- Chọn buổi -----') + VideoTypes::lists('name','id')->toArray();

        $this->data['tags'] = DB::select('select id, title from tags');

        return view("{$this->data['moduleName']}.{$this->data['controllerName']}.add", $this->buildDataView($this->data));
    }

    /**
     * Enter description here ...
     * @param StorageRequest $request
     * @return Ambigous <\Illuminate\Routing\Redirector, \Illuminate\Http\RedirectResponse>
     * @author HaLV
     */
    public function postAdd(VideosRequest $request) {

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
        $this->data['pcategories'] = array('' => '----- Chọn Category chính -----') + Categories::getOptionsCategoryByType(1);
        $this->data['categories'] = array('' => '----- Chọn Category phụ -----') + Categories::getOptionsCategoryByType(2);
        $this->data['types'] = array('' => '----- Chọn buổi -----') + VideoTypes::lists('name','id')->toArray();

        $ctags = DB::select('select tag_id from tag_video where video_id=?', [$id]);
        $tags = $this->toKeyPairs('id', DB::select('select id, title from tags'));
        foreach ($ctags as $v) {
            $k = $v->tag_id;
            if(isset($tags[$k])) {
                $tags[$k]->checked = true;
            }
        }
        $this->data['tags'] = $tags;


        $object = $this->_model->findOrNew($id)->toArray();

        if (empty($object)) {
            throw new \Exception('Not found!');
        }

        $object['is_new_image'] = 0;
        $object['is_new_video'] = 0;

        //$object['ingredients'] = json_decode($object['ingredients']);

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
    public function postEdit(VideosRequest $request, $id) {
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
            $this->_model->removeVideoMulti($this->_params['ids']);
            return response()->json(['msg' => 'Bỏ kích hoạt Video thành công!']);
        }
        return response()->json(['msg' => 'Bỏ kích hoạt Video không thành công!']);
    }

    /**
     * Enter description here ...
     * @return Ambigous <\Illuminate\Routing\Redirector, \Illuminate\Http\RedirectResponse>
     * @author HaLV
     */
    public function postActive() {
        if (isset($this->_params['ids'])) {
            $this->_model->activeMulti($this->_params['ids']);
            return response()->json(['msg' => 'Kích hoạt Video thành công!']);
        }
        return response()->json(['msg' => 'Kích hoạt Video không thành công!']);
    }


    /**
     * Enter description here ...
     * @return Ambigous <\Illuminate\Routing\Redirector, \Illuminate\Http\RedirectResponse>
     * @author HaLV
     */
    public function postFeatured() {
        if (isset($this->_params['ids'])) {
            $this->_model->featuredMulti($this->_params['ids']);
            return response()->json(['msg' => 'Thiết lập nổi bật Video thành công!']);
        }
        return response()->json(['msg' => 'Thiết lập nổi bật Video không thành công!']);
    }

    /**
     * Enter description here ...
     * @return Ambigous <\Illuminate\Routing\Redirector, \Illuminate\Http\RedirectResponse>
     * @author HaLV
     */
    public function postUnFeatured() {
        if (isset($this->_params['ids'])) {
            $this->_model->unFeaturedMulti($this->_params['ids']);
            return response()->json(['msg' => 'Bỏ nổi bật Video thành công!']);
        }
        return response()->json(['msg' => 'Bỏ nổi bật Video không thành công!']);
    }

    /**
     * Enter description here ...
     * @return Ambigous <\Illuminate\Routing\Redirector, \Illuminate\Http\RedirectResponse>
     * @author HaLV
     */
    public function postRecipe() {
        if (isset($this->_params['ids'])) {
            $this->_model->recipeMulti($this->_params['ids']);
            return response()->json(['msg' => 'Thiết lập sổ tay thành công!']);
        }
        return response()->json(['msg' => 'Thiết lập sổ tay không thành công!']);
    }

    /**
     * Enter description here ...
     * @return Ambigous <\Illuminate\Routing\Redirector, \Illuminate\Http\RedirectResponse>
     * @author HaLV
     */
    public function postUnRecipe() {
        if (isset($this->_params['ids'])) {
            $this->_model->unRecipeMulti($this->_params['ids']);
            return response()->json(['msg' => 'Bỏ nổi sổ tay thành công!']);
        }
        return response()->json(['msg' => 'Bỏ sổ tay không thành công!']);
    }

    /**
     * Enter description here ...
     * @return Ambigous <\Illuminate\Routing\Redirector, \Illuminate\Http\RedirectResponse>
     * @author HaLV
     */
    public function postUpdateOrdering() {
        if (isset($this->_params['ids'])) {
//             echo '<pre>';
//             print_r($this->_params['ids']);
//             echo '</pre>';
            $this->_model->updateOrdering($this->_params['ids']);
            return response()->json(['msg' => 'Cập nhật thứ tự thành công!']);
        }
        return response()->json(['msg' => 'Cập nhật thứ tự không thành công!']);
    }

    /**
     * List staffs request
     * @return JSON
     * @author HaLV
     */
    public function getAjaxDataTopView(Request $request)
    {
        $filter = [
        'offset' => $request->input('offset', 0),
        'limit' => $request->input('limit', PAGE_LIST_COUNT),
        'sort' => $request->input('sort', 'view_count'),
        'order' => $request->input('view_count', 'desc'),
        'search' => $request->input('search', ''),
        ];

        $data = $this->_model->getAllVideosTopView($filter);

        return response()->json([
                'total' => $data['total'],
                'rows' => $data['data'],
                ]);
    }


    /**
     * Retrieve and return the posts view/comments metrics
     *
     * @return JSON
     */
    public function getAjaxGetTopVideoByView() {
        $dataViews = $this->_model->getTopVideoByView();
        return (json_encode($dataViews));
    }

    //Export file excel, csv

    public function getExportExcel($type)
    {
        $data = $this->_model->getDataExport();

        Excel::create('report_video', function($excel) use($data) {
            $excel->sheet('Sheet 1', function($sheet) use($data) {
                $sheet->fromArray($data);
            });

        })->export($type);
    }

    public function getExportExcelTopView($type)
    {
        $data = $this->_model->getDataExportTopVideoByView();

        Excel::create('report_video', function($excel) use($data) {
            $excel->sheet('Sheet 1', function($sheet) use($data) {
                $sheet->fromArray($data);
            });

        })->export($type);
    }
}
