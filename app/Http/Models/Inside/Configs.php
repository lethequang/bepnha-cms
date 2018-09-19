<?php namespace App\Http\Models\Inside;

use App\MyCore\Inside\Models\DbTable;
use DB;
use App\Http\Requests\Inside\ConfigsRequest;

class Configs extends DbTable {

    public $tableTranslation = 'config_translations';
    public $primaryKey = 'config_id';

    public function __construct($options = array()) {
        parent::__construct($options);

        $this->table = 'configs';
        $this->fillable = ['is_deleted'];

        $this->searchs = array(
            'config_key_search' => "config_key"
        );

        $this->sorts = array(
            'config_id_sort'     => "config_id",
            'config_key_sort'   => "config_key",
            'dcreated_date_sort'  => "created_date",
            'is_deleted_sort'    => "is_deleted",
        );

        $this->filters = array(
            'is_deleted_filter' => "is_deleted",
        );

        $this->params = \Request::all();
    }

    /**
     * Enter description here ...
     * @param unknown $params
     * @param number $limit
     * @author Giau Le
     */
    public function showAll($params = array()) {
        $select = Configs::select()
            ->join($this->tableTranslation, function($join) {
                $join->on("{$this->tableTranslation}.{$this->primaryKey}", '=', "{$this->table}.{$this->primaryKey}")
                ->where("{$this->tableTranslation}.lang", '=', LANGUAGE_DEFAULT);
            });
        return $this->generateSelect($select);
    }

    /**
     * Enter description here ...
     * @param unknown $data
     * @return multitype:unknown
     * @author Giau Le
     */
    private function _formatDataToSaveTranslations(&$data) {
        $dataTranslations = array();
        foreach ($data as $key => $value) {
            if (strpos($key, '_lang_')) {
                $dataTranslations[$key] = $value;
                unset($data[$key]);
            }
        }
        return $dataTranslations;
    }

    /**
     * Enter description here ...
     * @param ConfigsRequest $request
     * @return unknown
     * @author Giau Le
     */
    public function add(ConfigsRequest $request) {
        /**
         * Lưu trong object
         */
        $object = new Configs();

        $data = $request->all();
        $dataTranslations = $this->_formatDataToSaveTranslations($data);
        $data = $this->_formatDataToSave($data);

        $this->filterColumns($data, $object);
        $object->save();

        $id = $object->{$object->primaryKey};

        $modelTranslations = new \App\Http\Models\Inside\TranslationsTable($this->tableTranslation, $this->primaryKey);
        $modelTranslations->add($id, $dataTranslations);

        return $id;
    }

    /**
     * Enter description here ...
     * @param ConfigsRequest $request
     * @param unknown $id
     * @return unknown
     * @author Giau Le
     */
    public function edit(ConfigsRequest $request, $id) {
        /**
         * Lưu trong object
         */
        $object = $this->findOrNew($id);

        $data = $request->all();
        $dataTranslations = $this->_formatDataToSaveTranslations($data);
        $data = $this->_formatDataToSave($data);

        $this->filterColumns($data, $object);
        $object->save();

        $modelTranslations = new \App\Http\Models\Inside\TranslationsTable($this->tableTranslation, $this->primaryKey);
        $modelTranslations->add($id, $dataTranslations);

        return $id;
    }

    /**
     * Enter description here ...
     * @author Giau Le
     */
    public function getOptions($isRoot = false) {
        $select = Configs::select()
            ->join($this->tableTranslation, function($join) {
                $join->on("{$this->tableTranslation}.{$this->primaryKey}", '=', "{$this->table}.{$this->primaryKey}")
                ->where("{$this->tableTranslation}.lang", '=', LANGUAGE_DEFAULT);
            })
            ->where('is_deleted', 0);

        return $select->lists('config_key', 'config_value')->toArray();
    }
}
