<?php

namespace App\MyCore\Inside\Models;

use Illuminate\Database\Eloquent\Model;
use App\MyCore\Inside\Helpers\ApiFile;
use Illuminate\Support\Facades\Storage;
use DB;

class DbTable extends Model {

    const CREATED_AT = 'date_created';
    const UPDATED_AT = 'date_modified';

    protected $table = null;
    protected $fillable = array();
    public $searchs = array();
    public $sorts = array();
    public $filters = array();
    public $params = array();
    public $user = null;

    public function __construct($options = array()) {
        parent::__construct($options);
    }

    /**
     * Lấy danh sách column trong table
     *
     * @return multitype:
     * @author HaLV
     */
    public function getColumnsInTable() {
        $columns = array();
        $adapter = $this->adapter;
        $columnObjects = DB::select("DESCRIBE {$this->table}");
        foreach ($columnObjects as $columnObject) {
            $columns[] = $columnObject->Field;
        }
        return $columns;
    }

    /**
     * Lọc lại data theo column
     *
     * @param unknown $data
     * @param unknown $object
     * @return multitype:unknown
     * @author HaLV
     */
    public function filterColumns($data, &$object) {
        $dataFormat = array();

        $columns = $this->getColumnsInTable();

        foreach ($data as $column => $value) {
            if (in_array($column, $columns)) {
                $object->$column = $value;
                $this->$column = $value;
                $dataFormat[$column] = $value;
            }
        }

        return $dataFormat;
    }

    /**
     * Enter description here ...
     * @param unknown $id
     * @author HaLV
     */
    public function remove($id) {
        /**
         * Lưu trong object
         */
        $object = $this->findOrNew($id);
        if ($object->exists) {
            $object->disable = !$object->disable;
            return $object->save();
        }
        return false;
    }

    /**
     * Enter description here ...
     * @param unknown $id
     * @param unknown $status
     * @author HaLV
     */
    public function changeStatus($id, $status) {
        /**
         * Lưu trong object
         */
        $object = $this->findOrNew($id);
        $categoryds = $object->descendants()->lists($this->primaryKey);
        if ($object->exists) {
            $object->process_status = $status;
            if ($status == 'deleted') {
                if (count($categoryds)) {
                    $this->whereIn($this->primaryKey, $categoryds)->update(array('process_status' => $status));
                }
            }
            return $object->save();
        }
        return false;
    }

    /**
     * Enter description here ...
     * @param unknown $ids
     * @author HaLV
     */
    public function removeMulti($ids) {
        foreach ($ids as $id) {
            /**
             * Lưu trong object
             */
            $object = $this->findOrNew($id);
            if ($object->exists) {
                $object->disable = !$object->disable;
                if(isset($object->modified_by))
                {
                    $object->modified_by = \Auth::id();
                }
                $object->save();
            }
        }
    }

    /**
     * Enter description here ...
     * @param unknown $ids
     * @author HaLV
     */
    public function removeVideoMulti($ids) {
        foreach ($ids as $id) {
            /**
             * Lưu trong object
             */
            $object = $this->findOrNew($id);
            if ($object->exists) {
                $object->disable = 1;
                if(isset($object->modified_by))
                {
                    $object->modified_by = \Auth::id();
                }
                $object->save();
            }
        }
    }

    /**
     * Enter description here ...
     * @param unknown $ids
     * @author HaLV
     */
    public function updateOrdering($ids) {

//         echo '<pre>';
//         print_r($ids);
//         echo '</pre>';

        $i = 1;
        foreach ($ids as $id) {
            /**
             * Lưu trong object
             */
            $object = $this->findOrNew($id);
            if ($object->exists) {
                $object->ordering = $i;
                $object->save();
                $i++;
            }
        }
    }

    /**
     * Enter description here ...
     * @param unknown $ids
     * @author HaLV
     */
    public function activeMulti($ids) {
        foreach ($ids as $id) {
            /**
             * Lưu trong object
             */
            $object = $this->findOrNew($id);
            if ($object->exists) {
                $object->disable = 0;
                if(isset($object->modified_by))
                {
                    $object->modified_by = \Auth::id();
                }
                $object->save();
            }
        }
    }

    /**
     * Enter description here ...
     * @param unknown $ids
     * @author HaLV
     */
    public function featuredMulti($ids) {
        foreach ($ids as $id) {
            /**
             * Lưu trong object
             */
            $object = $this->findOrNew($id);
            if ($object->exists) {
                $object->is_featured = 1;
                if(isset($object->modified_by))
                {
                    $object->modified_by = \Auth::id();
                }
                $object->save();
            }
        }
    }

    /**
     * Enter description here ...
     * @param unknown $ids
     * @author HaLV
     */
    public function unFeaturedMulti($ids) {
        foreach ($ids as $id) {
            /**
             * Lưu trong object
             */
            $object = $this->findOrNew($id);
            if ($object->exists) {
                $object->is_featured = 0;
                if(isset($object->modified_by))
                {
                    $object->modified_by = \Auth::id();
                }
                $object->save();
            }
        }
    }

    /**
     * Enter description here ...
     * @param unknown $ids
     * @author HaLV
     */
    public function recipeMulti($ids) {
        foreach ($ids as $id) {
            /**
             * Lưu trong object
             */
            $object = $this->findOrNew($id);
            if ($object->exists) {
                $object->is_recipe = 1;
                if(isset($object->modified_by))
                {
                    $object->modified_by = \Auth::id();
                }
                $object->save();
            }
        }
    }

    /**
     * Enter description here ...
     * @param unknown $ids
     * @author HaLV
     */
    public function unRecipeMulti($ids) {
        foreach ($ids as $id) {
            /**
             * Lưu trong object
             */
            $object = $this->findOrNew($id);
            if ($object->exists) {
                $object->is_recipe = 0;
                if(isset($object->modified_by))
                {
                    $object->modified_by = \Auth::id();
                }
                $object->save();
            }
        }
    }

    /**
     * Enter description here ...
     * @param unknown $select
     * @return unknown
     * @author HaLV
     */
    public function generateSelect($select) {
        $this->params = \Request::all();
        if (count($this->params)) {
            if (isset($this->params['search_type']) && isset($this->params['search_keyword']) && strlen($this->params['search_type']) && strlen($this->params['search_keyword'])) {
                if ($this->params['search_type'] === 'ALL') {
                    /**
                     * search all
                     */
                    if (count($this->searchs)) {
                        $conditions = array();
                        $select->where(function($query) {
                            foreach ($this->searchs as $search) {
                                $query->orWhere($search, 'like', "%{$this->params['search_keyword']}%");
                            }
                        });
                    }
                } else {
                    $select->where($this->searchs[$this->params['search_type']], 'like', "%{$this->params['search_keyword']}%");
                }
            }
            foreach ($this->params as $paramKey => $paramValue) {
                if (in_array($paramKey, array_keys($this->sorts))) {
                    /**
                     * sort
                     */
                    if ($paramValue === 'ASC') {
                        $select->orderBy($this->sorts[$paramKey], 'ASC');
                    } else {
                        $select->orderBy($this->sorts[$paramKey], 'DESC');
                    }
                } elseif (in_array($paramKey, array_keys($this->filters))) {
                    /**
                     * filter
                     */
                    $select->where($this->filters[$paramKey], $paramValue);
                }
            }
        }

        return $select;
    }

    /**
     * Enter description here ...
     * @param unknown $data
     * @author HaLV
     */
    public function saveImage($data) {
        $url = 'http://' . $_SERVER['HTTP_HOST'] . '/save.php';
        return ApiFile::save($url, $data);
    }

    /**
     * Enter description here ...
     * @param unknown $data
     * @author HaLV
     */
    public function saveFile($path, $fileName) {
        if (!is_dir($path)) mkdir($path, 0777, true);
        return copy(dirname(__FILE__) . "/../../../../public/upload/temp/{$fileName}", "{$path}/{$fileName}");
    }
    public function delFile($path, $fileName) {
        $fullpath = $path.'/'.$fileName;
        Storage::delete($fullpath);
    }

    /**
     * @param $type
     * @return mixed
     */
    public function getOptionsLanguages() {
        return array(
                'vi' => 'Tiếng Việt',
                'en' => 'Tiếng Anh',
        );
    }

    /**
     * @param $type
     * @return mixed
     */
    public function getOptionsStatus() {
        return array(
                'active' => 'Hoạt động',
                'inactive' => 'Không hoạt động',
        );
    }

    /**
     * @param $type
     * @return mixed
     */
    public function getOptionsFeatured() {
        return array(
                'featured' => 'Nổi bật',
                'unfeatured' => 'Không nổi bật',
        );
    }

    /**
     * @param $type
     * @return mixed
     */
    public function getOptionsNew() {
        return array(
                'is_new' => 'Món mới',
                'is_not_new' => 'Không phải món mới',
        );
    }

    /**
     * @param $type
     * @return mixed
     */
    public function getOptionsLike() {
        return array(
                'is_like' => 'Món yêu thích',
                'is_not_like' => 'Không phải món yêu thích',
        );
    }

    /**
     * @param $type
     * @return mixed
     */
    public function getOptionsForYou() {
        return array(
                'is_for_you' => 'Món ngon cho bạn',
                'is_not_for_you' => 'Không phải món ngon cho bạn',
        );
    }

    /**
     * @param $type
     * @return mixed
     */
    public function getOptionsRecipe() {
        return array(
                'recipe' => 'Sổ tay',
                'unrecipe' => 'Không là sổ tay',
        );
    }

    public function remove_empty($array) {

        $result = array();

        foreach ($array as $key => $value)
        {
            if(empty($value))
            {
                unset($array[$key]);
            }
            else
            {
                $result[] = $array[$key];
            }

        }

        return $result;
    }

    public function _formatDataToSave($data) {
        if (isset($data['_token']))
            unset($data['_token']);
        return $data;
    }

}
