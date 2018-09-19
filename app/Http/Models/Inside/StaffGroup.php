<?php

namespace App\Http\Models\Inside;

use App\MyCore\Inside\Models\DbTable;
use DB;
use App\Http\Requests\Inside\GroupsRequest;

class StaffGroup extends DbTable {

    public $timestamps = false;
    public $primaryKey = 'id';

    public function __construct($options = array()) {
        parent::__construct($options);

        $this->table = 'staff_group';
        $this->fillable = ['disable'];

        $this->searchs = array(
            'name_search' => "name"
        );

        $this->sorts = array(
        );

        $this->filters = array(
            'disable_filter' => "disable",
        );
    }


    /**
     * Enter description here ...
     * @param unknown $params
     * @param number $limit
     * @author HaLV
     */
    public function showAll() {

        $select = staff_group::select()
            ->where('disable', 0)
            ->orderBy('id', 'DESC');

        return $this->generateSelect($select);
    }

    /**
     * List Location
     * @param array $filter
     * @return array
     * @author HaLV
     */
    public function getAllStaffGroups($filter)
    {
        $scope = [
            'id', 'name', 'disable'
        ];

        $sql = self::select($scope)
        ->where('disable', 0);

        if (!empty($keyword = $filter['search'])) {
            $sql->where(function ($query) use ($keyword) {
                $query->where('name', 'LIKE', '%' . $keyword . '%');
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
     * Remove Location
     * @param array $ids
     * @return unknown
     * @author HaLV
     */
    public function removeMultiLocation($ids)
    {
        $items = Location::where('disable', 0)
            ->whereIn('id', $ids)
            ->pluck('id')
            ->toArray();

        if (count($items) === 0) {
            return;
        }

        DB::transaction(function () use ($items) {
            Location::whereIn('id', $items)->update(['disable' => 1]);
        });
    }

    /**
     * Enter description here ...
     * @param FeatureRequest $request
     * @return unknown
     * @author Giau Le
     */
    public function add(LocationRequest $request) {
        /**
         * Lưu trong object
         */
        $object = new Location;

        $data = $request->all();
        $data = $this->_formatDataToSave($data);

        $this->filterColumns($data, $object);

        $object->save();

        return $object->{$object->primaryKey};
    }

    /**
     * Enter description here ...
     * @param FeatureRequest $request
     * @param unknown $id
     * @return unknown
     * @author Giau Le
     */
    public function edit(LocationRequest $request, $id) {
        /**
         * Lưu trong object
         */
        $object = $this->findOrNew($id);

        $data = $request->all();
        $data = $this->_formatDataToSave($data);

        $this->filterColumns($data, $object);
        $object->save();

        return $id;
    }

    /**
     * @param $type
     * @return mixed
     */
    public static function getOptionsLocation($default = true) {
        $data = array(
            '' => '----- Chọn khu vực -----'
        );
        $result = Location::where('disable', 0)->orderBy('name')->lists('name', 'id')->toArray();
        if($default == true)
            $result = $data + $result;
        return $result;
    }

    /**
     * @return array
     */
    public static function getLocation() {
        $rows = Location::where('disable', 0)->get()->toArray();
        $data = array();
        foreach ($rows as $row) {
            $data[$row['id']] = $row;
        }
        return $data;
    }

    /**
     * @author Ly Nguyen <huuly188@gmail.com>
     * @return array List location id=>name
     */
    public static function getListLocation() {
        return Location::where('disable', 0)->lists('name','id')->toArray();
    }

    /**
     * @author Ly Nguyen <huuly188@gmail.com>
     * @param  array $storageIds List Storage Id
     * @return array             List Location id=>name
     */
    public static function getListLocationByListStorage($storageIds) {
        $listLocationIds = DB::table('storage')->whereIn('id', $storageIds)->distinct()->lists('location');
        return Location::where('disable', 0)->whereIn('id', $listLocationIds)->lists('name','id')->toArray();
    }
}
