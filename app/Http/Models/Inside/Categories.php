<?php

namespace App\Http\Models\Inside;

use App\MyCore\Inside\Models\DbTable;
use App\Http\Requests\Inside\CategoriesRequest;
use DB;
use Session;

class Categories extends DbTable {

    public $timestamps = false;
    public $primaryKey = 'id';

    public function __construct($options = array()) {
        parent::__construct($options);

        $this->table = 'categories';
    }

    /**
     * List Type
     * @param array $filter
     * @return array
     * @author HaLV
     */
    public function getAllCategories($filter)
    {
        $scope = [
        'categories.id', 'categories.name', 'categories.date_created', 'categories.disable', 'categories_ref.name as parent_category_name',
        ];

        $sql = self::select($scope)
            ->leftJoin('categories AS categories_ref', 'categories_ref.id', '=', 'categories.parent_cate');

        if (!empty($keyword = $filter['search'])) {
            $sql->where(function ($query) use ($keyword) {
                $query->where('categories.name', 'LIKE', '%' . $keyword . '%');
            });
        }

        if (!empty($status = $filter['status'])) {
            if($status == 'active')
            {
                $sql->where('categories.disable', 0);
            }
            else
            {
                $sql->where('categories.disable', 1);
            }
        }

        if (!empty($filter['from']) && !empty($filter['to'])) {
            $from = date('Y-m-d', strtotime($filter['from'])) . ' 00:00:00';
            $to = date('Y-m-d', strtotime($filter['to'])) . ' 23:59:59';
            $sql->whereBetween('categories.date_created', [$from, $to]);
        } else if(!empty($filter['from'])) {
            $from = date('Y-m-d', strtotime($filter['from'])) . ' 00:00:00';
            $sql->whereDate('categories.date_created', '>=', $from);
        } else if (!empty($filter['to'])) {
            $to = date('Y-m-d', strtotime($filter['to'])) . ' 23:59:59';
            $sql->whereDate('categories.date_created', '<=', $to);
        }

        $total = $sql->count();

        $data = $sql->skip($filter['offset'])
        ->take($filter['limit'])
        ->orderBy($filter['sort'], $filter['order'])
        ->get()
        ->toArray();

        return ['total' => $total, 'data' => $data];
    }

    /**
     * Enter description here ...
     * @param FeatureRequest $request
     * @return unknown
     * @author HaLV
     */
    public function add(CategoriesRequest $request) {
        /**
         * Lưu trong object
         */

        $date = date("Y/m/d");
        $folder_image = 'categories';

        $object = new Categories;

        $data = $request->all();

        $data['created_by'] = \Auth::id();
        $data['date_created'] = date('Y-m-d H:i:s');

        $data = $this->_formatDataToSave($data);

        $this->filterColumns($data, $object);

        $isSuccess = false;

        DB::transaction(function () use ($object, &$isSuccess) {
            try {
                $object->save();
                $categoryId = $object->{$object->primaryKey};
                DB::commit();
                Session::flash('category-success-message', 'Thêm thông tin Category thành công.');
                $isSuccess = $categoryId;
            } catch (Exception $ex) {
                DB::rollback();
                Session::flash('category-error-message', 'Thêm thông tin Category thất bại. Vui lòng thử lại sau.');
            }
        });

        /**
         * Xử lý media
        */
        if ($isSuccess && $data['image_name']!="" && $data['is_new_image']=="1") {
            $dataMedia = array();

            /**
             * upload hinh
            */
            //if ($data['is_new_image']=="1") {
                $path = $_ENV['MEDIA_PATH_IMAGE'] . '/' . $folder_image . '/' . $date;
                $dataMedia['icon_location'] = $folder_image . '/' . $date . '/' . $data['image_name'];
                $this->saveFile($path, $data['image_name']);
            //}

            if (count($dataMedia))
                Categories::where('id', $isSuccess)->update($dataMedia);
        }

        return $isSuccess;
    }

    /**
     * Enter description here ...
     * @param FeatureRequest $request
     * @param unknown $id
     * @return unknown
     * @author HaLV
     */
    public function edit(CategoriesRequest $request, $id) {
        /**
         * Lưu trong object
         */
        $object = $this->findOrNew($id);
        $old_img = $object->icon_location;

        $date = date("Y/m/d");
        $folder_image = 'categories';

        $data = $request->all();

        //$isNewImage = $data['is_new_image'];

        $data = $this->_formatDataToSave($data);

        $data['modified_by'] = \Auth::id();
        $data['date_modified'] = date('Y-m-d H:i:s');

        $this->filterColumns($data, $object);

        $isSuccess = false;

        DB::transaction(function () use ($object, &$isSuccess) {
            try {
                $object->save();
                $categoryId = $object->{$object->primaryKey};
                DB::commit();
                Session::flash('partner-success-message', 'Chỉnh sửa thông tin Category thành công');
                $isSuccess = $categoryId;
            } catch (Exception $ex) {
                DB::rollback();
                Session::flash('partner-error-message', 'Chỉnh sửa thông tin Category thất bại. Vui lòng thử lại sau.');
                return false;
            }
        });

        /**
         * Xử lý media
        */
        if ($isSuccess && $data['image_name'] != "" && $data['is_new_image']=="1") {
            $dataMedia = array();
            /**
             * upload hinh
            */
            //if ($isNewImage) {
                $path = $_ENV['MEDIA_PATH_IMAGE'] . '/' . $folder_image . '/' . $date;
                $dataMedia['icon_location'] = $folder_image . '/' . $date . '/' . $data['image_name'];
                if(strlen($old_img) > 0) {
                    $this->delFile($_ENV['MEDIA_PATH_IMAGE'], $old_img);
                }
                $this->saveFile($path, $data['image_name']);
            //}

            if (count($dataMedia))
                Categories::where('id', $isSuccess)->update($dataMedia);
        }

        return $id;
    }

    /**
     * @param $type
     * @return mixed
     */
    public static function getParentCategoryOptions() {
        return Categories::where('disable', 0)->where('parent_cate', 0)->orderBy('type','id')->lists('name', 'id')->toArray();
    }

    /**
     * @param $type
     * @return mixed
     */
    public static function getOptionsCategoryById($id) {
        return Categories::where('disable', 0)->where('id', $id)->orderBy('name')->lists('name', 'id')->toArray();
    }

    /**
     * @param $type
     * @return mixed
     */
    public static function getOptionsCategory() {
        return Categories::where('disable', 0)->orderBy('type', 'name')->lists('name', 'id')->toArray();
    }

    public static function getOptionsCategoryByType($type) {
        return Categories::where('disable', 0)->where('type', $type)->orderBy('name')->lists('name', 'id')->toArray();
    }
}
