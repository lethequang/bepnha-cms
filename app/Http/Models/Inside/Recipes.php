<?php

namespace App\Http\Models\Inside;

use App\MyCore\Inside\Models\DbTable;
use DB;
use App\Http\Requests\Inside\RecipesRequest;

use Session;

class Recipes extends DbTable {

    public $timestamps = false;
    public $primaryKey = 'id';

    public function __construct($options = array()) {
        parent::__construct($options);

        $this->table = 'recipes';
    }

    /**
     * List Type
     * @param array $filter
     * @return array
     * @author HaLV
     */
    public function getAllRecipes($filter)
    {
        $scope = [
        'recipes.*','videos.name', 'videos.image_location'
        ];

        $sql = self::select($scope)
                ->leftJoin('videos', 'videos.id', '=', 'recipes.video_id');

        if (!empty($keyword = $filter['search'])) {
            $sql->where(function ($query) use ($keyword) {
                $query->where('recipes.serial_number', 'LIKE', '%' . $keyword . '%');
                $query->orWhere('videos.name', 'LIKE', '%' . $keyword . '%');
            });
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
    public function add(RecipesRequest $request) {
        /**
         * Lưu trong object
         */

        $date = date("Y/m/d");
        $folder_image = 'Recipes';

        $object = new Recipes;

        $data = $request->all();

        $isNewImage = $data['is_new_image'];
        $isNewImage1 = $data['is_new_image1'];

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
        if ($isSuccess) {
            $dataMedia = array();

            /**
             * upload hinh
            */
            if ($isNewImage) {
                $path = $_ENV['MEDIA_PATH_IMAGE'] . '/' . $folder_image . '/' . $date;
                $dataMedia['image_location'] = $folder_image . '/' . $date . '/' . $data['image_name'];
                $this->saveFile($path, $data['image_name']);
            }

            /**
             * upload hinh icon
             */
            if ($isNewImage1) {
                $path = $_ENV['MEDIA_PATH_IMAGE'] . '/' . $folder_image . '/' . $date;
                $dataMedia['icon_location'] = $folder_image . '/' . $date . '/' . $data['image_name1'];
                $this->saveFile($path, $data['image_name1']);
            }

            if (count($dataMedia))
                Recipes::where('id', $isSuccess)->update($dataMedia);
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
    public function edit(RecipesRequest $request, $id) {
        /**
         * Lưu trong object
         */
        $object = $this->findOrNew($id);

        $date = date("Y/m/d");
        $folder_image = 'Recipes';

        $data = $request->all();

        $isNewImage = $data['is_new_image'];
        $isNewImage1 = $data['is_new_image1'];

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
        if ($isSuccess) {
            $dataMedia = array();

            /**
             * upload hinh
            */
            if ($isNewImage) {
                $path = $_ENV['MEDIA_PATH_IMAGE'] . '/' . $folder_image . '/' . $date;
                $dataMedia['image_location'] = $folder_image . '/' . $date . '/' . $data['image_name'];
                $this->saveFile($path, $data['image_name']);
            }

            /**
             * upload hinh icon
             */
            if ($isNewImage1) {
                $path = $_ENV['MEDIA_PATH_IMAGE'] . '/' . $folder_image . '/' . $date;
                $dataMedia['icon_location'] = $folder_image . '/' . $date . '/' . $data['image_name1'];
                $this->saveFile($path, $data['image_name1']);
            }

            if (count($dataMedia))
                Recipes::where('id', $isSuccess)->update($dataMedia);
        }

        return $id;
    }

    /**
     * @param $type
     * @return mixed
     */
    public static function getParentCategoryOptions() {
        return Recipes::where('disable', 0)->where('parent_cate', 0)->orderBy('id')->lists('name', 'id')->toArray();
    }

    /**
     * @param $type
     * @return mixed
     */
    public static function getOptionsCategoryById($id) {
        return Recipes::where('disable', 0)->where('id', $id)->orderBy('name')->lists('name', 'id')->toArray();
    }

    /**
     * @param $type
     * @return mixed
     */
    public static function getOptionsCategory() {
        return Recipes::where('disable', 0)->orderBy('name')->lists('name', 'id')->toArray();
    }
}
