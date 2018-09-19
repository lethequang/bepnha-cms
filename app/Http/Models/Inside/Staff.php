<?php

namespace App\Http\Models\Inside;

use App\MyCore\Inside\Models\DbTable;
use DB;
use App\Http\Requests\Inside\StaffRequest;
use App\Http\Requests\Inside\UserRequest;
use Illuminate\Http\Request;
class Staff extends DbTable {

    const GROUP_SUPER_ADMIN = 1;
    const GROUP_ADMIN = 2;

    public $timestamps = false;
    public $primaryKey = 'id';

    public function __construct($options = array()) {
        parent::__construct($options);

        $this->table = 'staff';
        $this->fillable = ['disable'];

        $this->searchs = array(
            'email_search' => "email"
        );

        $this->sorts = array(
        );

        $this->filters = array(
            'disable_filter' => "disable",
        );
    }

    /**
     * Enter description here ...
     * @param FeatureRequest $request
     * @return unknown
     * @author Giau Le
     */
    public function add(StaffRequest $request) {
        /**
         * Lưu trong object
         */
        $object = new Staff;

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
    public function edit(StaffRequest $request, $id) {
        /**
         * Lưu trong object
         */
        $object = $this->findOrNew($id);

        $data = $request->all();
        $data = $this->_formatDataToSave($data);

        $this->filterColumns($data, $object);
        unset($object->password);
        $object->save();

        return $id;
    }


    /**
     * @param $type
     * @return mixed
     */
    public static function getOptionsByGroup($group) {

        $rows = Staff::select('id', 'email', 'fullname')->where('disable', 0)->where('group', $group)->get()->toArray();

        $result = array();

        foreach ($rows as $row)
        {
            $result[$row['id']] = $row['email'] .' - '.$row['fullname'];
        }
        return $result;
    }

    /**
     * @return array
     */
    public static function getStaff() {
        $rows = Staff::where('disable', 0)->get()->toArray();
        $data = array();
        foreach ($rows as $row) {
            $data[$row['id']] = $row;
        }
        return $data;
    }

    /**
     * Enter description here ...
     * @param array $data
     * @author HaLV
     */
    public static function addStaffByStorage($data) {
        return DB::table('staff')->insertGetId(
            array(
                'email'   => $data['email'],
                'password'   => $data['password'],
                'fullname'   => $data['fullname'],
                'group'   => $data['group'],
                'date_created'   => $data['date_created'],
            )
        );
    }

    /**
     * @author HaLV
     * @return array
     */
    public static function listStaffGroup()
    {
        return [
//             self::GROUP_SUPER_ADMIN,
            self::GROUP_ADMIN,
        ];
    }

    /**
     * @author HaLV
     * @return array
     */
    public static function listStaffGroupWithLabel()
    {
        return StaffGroup::where('disable', 0)->whereIn('id', self::listStaffGroup())->lists('name', 'id')->toArray();
    }

    /**
     * List staffs
     * @param array $filter
     * @return array
     * @author HaLV
     */
    public function listStaff($filter)
    {
        $scope = [
            'staff.id', 'staff.email', 'staff.fullname',
            'staff.phone', 'staff.group', 'staff.disable',
            'staff_group.name as group_name',
        ];
        $sql = self::select($scope)
            ->join('staff_group', 'group', '=', 'staff_group.id')
            ->whereIn('group', self::listStaffGroup());
        if (!empty($keyword = $filter['search'])) {
            $sql->where(function ($query) use ($keyword) {
                $query->where('staff.email', 'LIKE', '%' . $keyword . '%');
                $query->orWhere('staff.fullname', 'LIKE', '%' . $keyword . '%');
                $query->orWhere('staff.phone', 'LIKE', '%' . $keyword . '%');
                $query->orWhere('staff_group.name', 'LIKE', '%' . $keyword . '%');
            });
        }

        if (!empty($group = $filter['group'])) {
            $sql->where('group', $group);
        }

        if (!empty($status = $filter['status'])) {
            if($status == 'active')
            {
                $sql->where('staff.disable', 0);
            }
            else
            {
                $sql->where('staff.disable', 1);
            }
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
     * add staff
     * @param StaffRequest $request
     * @return array
     * @author HaLV
     */
    public function addStaff(StaffRequest $request)
    {
        $object = new Staff;
        $data = $request->all();
        $data = $this->_formatDataToSave($data);
        $this->filterColumns($data, $object);
        $object->password = bcrypt($object->password);
        $object->date_created = date('Y-m-d H:i:s');
        $object->save();
        return $object->{$object->primaryKey};
    }

    /**
     * Remove staffs
     * @param array $ids
     * @return unknown
     * @author HaLV
     */
    public function removeMultiStaff($ids)
    {
        $enabledList = Staff::where('staff.disable', 0)
            ->whereIn('staff.id', $ids)
            ->whereIn('staff.group', self::listStaffGroup())
            ->pluck('staff.id')
            ->toArray();
        $disabledList = Staff::where('staff.disable', 1)
            ->whereIn('staff.id', $ids)
            ->whereIn('staff.group', self::listStaffGroup())
            ->pluck('staff.id')
            ->toArray();
        if (count($enabledList + $disabledList) === 0) {
            return;
        }

        DB::transaction(function () use ($enabledList, $disabledList) {
            Staff::whereIn('id', $enabledList)->update(['disable' => 1]);
            Staff::whereIn('id', $disabledList)->update(['disable' => 0]);
        });
    }

    /**
     * @return array
     */
    public static function getStaffIdByCode($code) {
        $row = Staff::where('disable', 0)->where('email', $code)->first();

        if(!empty($row))
            $row->toArray();
            return $row['id'];

        return 0;
    }

    /**
     * Enter description here ...
     * @param FeatureRequest $request
     * @param unknown $id
     * @return unknown
     * @author HaLV
     */
    public function editUserProfile(Request $request, $id)
    {
        $object = $this->findOrNew($id);

        $data = $request->all();
        $data = $this->_formatDataToSave($data);

        $this->filterColumns($data, $object);
        unset($object->email);
        unset($object->group);
        unset($object->password);
        $object->save();

        return $id;
    }

}
