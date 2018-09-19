<?php namespace App\Http\Models\Inside;
/**
 * Created by PhpStorm.
 * User: Elegant
 * Date: 13/12/2016
 * Time: 10:56 SA
 */

use App\MyCore\Inside\Models\DbTable;
use Session;
use Illuminate\Http\Request;
use DB;

class Tags extends DbTable {
    protected $table = 'tags';

    public function __construct($options = array()) {
        parent::__construct($options);
    }

    public function getAllTags($filter)
    {
        $scope = [
            'tags.id', 'tags.title', 'tags.date_created', 'tags.disable', 'tags.order_by'
        ];

        $sql = self::select($scope);

        if (!empty($keyword = $filter['search'])) {
            $sql->where(function ($query) use ($keyword) {
                $query->where('tags.name', 'LIKE', '%' . $keyword . '%');
            });
        }

        if (!empty($status = $filter['status'])) {
            if($status == 'active')
            {
                $sql->where('tags.disable', 0);
            }
            else
            {
                $sql->where('tags.disable', 1);
            }
        }

        if (!empty($filter['from']) && !empty($filter['to'])) {
            $from = date('Y-m-d', strtotime($filter['from'])) . ' 00:00:00';
            $to = date('Y-m-d', strtotime($filter['to'])) . ' 23:59:59';
            $sql->whereBetween('tags.date_created', [$from, $to]);
        } else if(!empty($filter['from'])) {
            $from = date('Y-m-d', strtotime($filter['from'])) . ' 00:00:00';
            $sql->whereDate('tags.date_created', '>=', $from);
        } else if (!empty($filter['to'])) {
            $to = date('Y-m-d', strtotime($filter['to'])) . ' 23:59:59';
            $sql->whereDate('tags.date_created', '<=', $to);
        }

        $total = $sql->count();

        $data = $sql->skip($filter['offset'])
            ->take($filter['limit'])
//            ->orderBy($filter['sort'], $filter['order'])
            ->orderBy('order_by')
            ->get()
            ->toArray();

        return ['total' => $total, 'data' => $data];
    }
    public function add(Request $request) {
        /**
         * Lưu trong object
         */

        $object = new Tags;

        $data = $request->all();

        $data['created_by'] = \Auth::id();
        $data['date_created'] = date('Y-m-d H:i:s');

        $this->filterColumns($data, $object);

        $isSuccess = false;

        DB::transaction(function () use ($object, &$isSuccess) {
            try {
                $object->save();
                $categoryId = $object->{$object->primaryKey};
                DB::commit();
                Session::flash('tag-success-message', 'Thêm thông tag thành công.');
                $isSuccess = $categoryId;
            } catch (Exception $ex) {
                DB::rollback();
                Session::flash('tag-error-message', 'Thêm tag thất bại. Vui lòng thử lại sau.');
            }
        });

        return $isSuccess;
    }

    public function edit(Request $request, $id) {
        /**
         * Lưu trong object
         */
        $object = $this->findOrNew($id);

        $data = $request->all();

        $data['modified_by'] = \Auth::id();
        $data['date_modified'] = date('Y-m-d H:i:s');

        $data = $this->_formatDataToSave($data);

        $this->filterColumns($data, $object);

        $isSuccess = false;

        DB::transaction(function () use ($object, &$isSuccess) {
            try {
                $object->save();
                $categoryId = $object->{$object->primaryKey};
                DB::commit();
                Session::flash('tag-edit-success-message', 'Chỉnh sửa tag thành công');
                $isSuccess = $categoryId;
            } catch (Exception $ex) {
                DB::rollback();
                Session::flash('tag-edit-error-message', 'Chỉnh sửa tag thất bại. Vui lòng thử lại sau.');
                return false;
            }
        });

        return $id;
    }

    public function updateOrderBy($id, $order_by){
        $object = $this->findOrNew($id);
        if ($object->exists) {
            $object->order_by = $order_by;
            $object->save();
        }
    }
}