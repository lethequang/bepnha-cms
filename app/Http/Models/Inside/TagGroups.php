<?php

/**
 * Created by PhpStorm.
 * User: Elegant
 * Date: 13/12/2016
 * Time: 10:56 SA
 */

namespace App\Http\Models\Inside;

use App\MyCore\Inside\Models\DbTable;
use DB;
use Session;
use Illuminate\Http\Request;

class TagGroups extends DbTable {
    protected $table = 'tag_groups';

    public function __construct($options = array()) {
        parent::__construct($options);
    }

    public function getAllTags($filter)
    {
        $scope = [
            'tag_groups.id', 'tag_groups.title', 'tag_groups.date_created', 'tag_groups.disable'
        ];

        $sql = self::select($scope);

        if (!empty($keyword = $filter['search'])) {
            $sql->where(function ($query) use ($keyword) {
                $query->where('tag_groups.name', 'LIKE', '%' . $keyword . '%');
            });
        }

        if (!empty($status = $filter['status'])) {
            if($status == 'active')
            {
                $sql->where('tag_groups.disable', 0);
            }
            else
            {
                $sql->where('tag_groups.disable', 1);
            }
        }

        if (!empty($filter['from']) && !empty($filter['to'])) {
            $from = date('Y-m-d', strtotime($filter['from'])) . ' 00:00:00';
            $to = date('Y-m-d', strtotime($filter['to'])) . ' 23:59:59';
            $sql->whereBetween('tag_groups.date_created', [$from, $to]);
        } else if(!empty($filter['from'])) {
            $from = date('Y-m-d', strtotime($filter['from'])) . ' 00:00:00';
            $sql->whereDate('tag_groups.date_created', '>=', $from);
        } else if (!empty($filter['to'])) {
            $to = date('Y-m-d', strtotime($filter['to'])) . ' 23:59:59';
            $sql->whereDate('tag_groups.date_created', '<=', $to);
        }

        $total = $sql->count();

        $data = $sql->skip($filter['offset'])
            ->take($filter['limit'])
            ->orderBy($filter['sort'], $filter['order'])
            ->get()
            ->toArray();

        return ['total' => $total, 'data' => $data];
    }
    public function add(Request $request) {
        /**
         * Lưu trong object
         */

        $object = new TagGroups;

        $data = $request->all();

        $data['created_by'] = \Auth::id();
        $data['date_created'] = date('Y-m-d H:i:s');

        $this->filterColumns($data, $object);

        $isSuccess = false;

        DB::transaction(function () use ($data, $object, &$isSuccess) {
            try {
                $object->save();
                $tagGroupsId = $object->{$object->primaryKey};

                if(isset($data['tags'])) {
                    foreach ($data['tags'] as $tagid) {
                        DB::table('tag_grouped')->insert(['tag_group_id' => $tagGroupsId, 'tag_id' => $tagid]);
                    }
                }

                DB::commit();
                Session::flash('tag-group-success-message', 'Thêm thông tag thành công.');
                $isSuccess = $tagGroupsId;
            } catch (Exception $ex) {
                DB::rollback();
                Session::flash('tag-group-error-message', 'Thêm tag thất bại. Vui lòng thử lại sau.');
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

        $tags = isset($data['tags'])?$data['tags']:[];

        $this->filterColumns($data, $object);

        $isSuccess = false;

        DB::transaction(function () use ($tags, $object, &$isSuccess) {
            try {
                $object->save();
                $tagGroupsId = $object->{$object->primaryKey};

                DB::table('tag_grouped')->where('tag_group_id', '=', $tagGroupsId)->delete();
                foreach($tags as $tagid) {
                    DB::table('tag_grouped')->insert(['tag_group_id' => $tagGroupsId, 'tag_id' => $tagid]);
                }

                DB::commit();
                Session::flash('tag-edit-success-message', 'Chỉnh sửa tag thành công');
                $isSuccess = $tagGroupsId;
            } catch (Exception $ex) {
                DB::rollback();
                Session::flash('tag-edit-error-message', 'Chỉnh sửa tag thất bại. Vui lòng thử lại sau.');
                return false;
            }
        });

        return $id;
    }
}