<?php

namespace App\Http\Models\Inside;

use App;
use App\MyCore\Inside\Models\DbTable;
use App\Http\Requests\Inside\VideosRequest;
use DB;
use Session;

class Videos extends DbTable {

    public $timestamps = false;
    public $primaryKey = 'id';

    public function __construct($options = array()) {
        parent::__construct($options);

        $this->table = 'videos';
    }

    /**
     * List Type
     * @param array $filter
     * @return array
     * @author HaLV
     */
    public function getAllVideos($filter)
    {
        $scope = [ 'videos.*', 'categories.name as category_name'];

        $sql = self::select($scope)
            ->leftJoin('categories', 'categories.id', '=', 'videos.category_id');

        if (!empty($keyword = $filter['search'])) {
            $sql->where(function ($query) use ($keyword) {
                $query->where('videos.name', 'LIKE', '%' . $keyword . '%');
                $query->orWhere('categories.name', 'LIKE', '%' . $keyword . '%');
            });
        }

        if (!empty($pcategory = $filter['pcategory'])) {
            $sql->where('videos.pcategory_id', $pcategory);
        }
        if (!empty($category = $filter['category'])) {
            $sql->where('videos.category_id', $category);
        }

        if (!empty($status = $filter['status'])) {
            if($status == 'active')
            {
                $sql->where('videos.disable', 0);
            }
            elseif($status == 'inactive')
            {
                $sql->where('videos.disable', 1);
            }
            else
            {
                $sql->whereIn('videos.disable', array(0,1));
            }
        }

        if (!empty($filter['from']) && !empty($filter['to'])) {
            $from = date('Y-m-d', strtotime($filter['from'])) . ' 00:00:00';
            $to = date('Y-m-d', strtotime($filter['to'])) . ' 23:59:59';
            $sql->whereBetween('videos.date_created', [$from, $to]);
        } else if(!empty($filter['from'])) {
            $from = date('Y-m-d', strtotime($filter['from'])) . ' 00:00:00';
            $sql->whereDate('videos.date_created', '>=', $from);
        } else if (!empty($filter['to'])) {
            $to = date('Y-m-d', strtotime($filter['to'])) . ' 23:59:59';
            $sql->whereDate('videos.date_created', '<=', $to);
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
     * List Type
     * @param array $filter
     * @return array
     * @author HaLV
     */
    public function getFeaturedVideos($filter)
    {
        $scope = [
        'videos.*', 'categories.name as category_name'
                ];

        $sql = self::select($scope)
        ->leftJoin('categories', 'categories.id', '=', 'videos.category_id');

        $sql->where('videos.is_featured', 1);

        if (!empty($keyword = $filter['search'])) {
            $sql->where(function ($query) use ($keyword) {
                $query->where('videos.name', 'LIKE', '%' . $keyword . '%');
                $query->orWhere('categories.name', 'LIKE', '%' . $keyword . '%');
            });
        }

        if (!empty($category = $filter['category'])) {
            $sql->where('videos.category_id', $category);
        }

        if (!empty($status = $filter['status'])) {
            if($status == 'active')
            {
                $sql->where('videos.disable', 0);
            }
            else
            {
                $sql->where('videos.disable', 1);
            }
        }

        if (!empty($filter['from']) && !empty($filter['to'])) {
            $from = date('Y-m-d', strtotime($filter['from'])) . ' 00:00:00';
            $to = date('Y-m-d', strtotime($filter['to'])) . ' 23:59:59';
            $sql->whereBetween('videos.date_created', [$from, $to]);
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
     * List Type
     * @param array $filter
     * @return array
     * @author HaLV
     */
    public function getRecipeVideos($filter)
    {
        $scope = [
        'videos.*', 'categories.name as category_name'
                ];

        $sql = self::select($scope)
        ->leftJoin('categories', 'categories.id', '=', 'videos.category_id');

        $sql->where('videos.is_recipe', 1);

        if (!empty($keyword = $filter['search'])) {
            $sql->where(function ($query) use ($keyword) {
                $query->where('videos.name', 'LIKE', '%' . $keyword . '%');
                $query->orWhere('categories.name', 'LIKE', '%' . $keyword . '%');
            });
        }

        if (!empty($category = $filter['category'])) {
            $sql->where('videos.category_id', $category);
        }

        if (!empty($status = $filter['status'])) {
            if($status == 'active')
            {
                $sql->where('videos.disable', 0);
            }
            else
            {
                $sql->where('videos.disable', 1);
            }
        }

        if (!empty($filter['from']) && !empty($filter['to'])) {
            $from = date('Y-m-d', strtotime($filter['from'])) . ' 00:00:00';
            $to = date('Y-m-d', strtotime($filter['to'])) . ' 23:59:59';
            $sql->whereBetween('videos.date_created', [$from, $to]);
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
     * List Type
     * @param array $filter
     * @return array
     * @author HaLV
     */
    public function getAllVideosTopView($filter)
    {
        $scope = [
        'videos.*', 'categories.name as category_name'
                ];

        $sql = self::select($scope)
        ->leftJoin('categories', 'categories.id', '=', 'videos.category_id');

        if (!empty($keyword = $filter['search'])) {
            $sql->where(function ($query) use ($keyword) {
                $query->where('videos.name', 'LIKE', '%' . $keyword . '%');
                $query->orWhere('categories.name', 'LIKE', '%' . $keyword . '%');
            });
        }

        $sql->where('videos.disable', 0);

        $total = $sql->count();

         $data = $sql->limit(50)
        ->orderBy($filter['sort'], $filter['order'])
        ->get()
        ->toArray();

        return ['total' => $total, 'data' => $data];
    }

    /**
     * Enter description here ...
     * @param VideoRequest $request
     * @return unknown
     * @author HaLV
     */
    public function add(VideosRequest $request) {

        $date = date("Y/m/d");
        $folder_image = 'videos';

        /**
         * Lưu trong object
        */
        $object = new Videos;

        $data = $request->all();

        $isNewImage = $data['is_new_image'];
        //$isNewImage1 = $data['is_new_image1'];
        $isNewVideo = $data['is_new_video'];

        //$data['ingredients'] = $this->remove_empty($data['ingredients']);

        //$data['ingredients'] = json_encode($data['ingredients']);

        $data = $this->_formatDataToSave($data);

        $data['date_created'] = date('Y-m-d H:i:s');
        $data['created_by'] = \Auth::id();

        if(isset($data['is_home']) && $data['is_home'] == 'on'){
            $data['is_home'] = 1;
        }else{
            $data['is_home'] = 0;
        }

        $this->filterColumns($data, $object);

        $isSuccess = false;

        DB::transaction(function () use ($data, $object, &$isSuccess) {
            try {
                $object->save();
                $videoId = $object->{$object->primaryKey};


                if(isset($data['tags']))
                    foreach($data['tags'] as $tagid) {
                        DB::table('tag_video')->insert(['video_id' => $videoId, 'tag_id' => $tagid]);
                    }

                DB::commit();
                Session::flash('video-success-message', 'Thêm thông tin Video thành công.');
                $isSuccess = $videoId;
            } catch (Exception $ex) {
                DB::rollback();
                Session::flash('video-error-message', 'Thêm thông tin Video thất bại. Vui lòng thử lại sau.');
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

            /*
            if ($isNewImage1) {
                $path = $_ENV['MEDIA_PATH_IMAGE'] . '/' . $folder_image . '/' . $date;
                $dataMedia['background_location'] = $folder_image . '/' . $date . '/' . $data['image_name1'];
                $this->saveFile($path, $data['image_name1']);
            }
            */

            /**
             * upload video
             */
            if ($isNewVideo) {
                $path = $_ENV['MEDIA_PATH_VIDEO']. '/' . $date;
                $dataMedia['video_location'] = $date . '/' . $data['video_name'];
                $this->saveFile($path, $data['video_name']);
            }

            if (count($dataMedia))
                Videos::where('id', $isSuccess)->update($dataMedia);
        }

        return $isSuccess;
    }

    /**
     * Enter description here ...
     * @param VideoRequest $request
     * @param unknown $id
     * @return unknown
     * @author HaLV
     */

    public function edit(VideosRequest $request, $id) {

        /**
         * Lưu trong object
         */
        $object = $this->findOrNew($id);
        $old_image = $object->image_location;
        $old_video = $object->video_location;


        $date = date("Y/m/d");
        $folder_image = 'videos';

        $data = $request->all();

        /*
        if(!isset($data['is_featured']))
            $data['is_featured'] = 0;

        if(!isset($data['is_like']))
            $data['is_like'] = 0;

        if(!isset($data['is_new']))
            $data['is_new'] = 0;

        if(!isset($data['is_for_you']))
            $data['is_for_you'] = 0;
        */

        $isNewImage = $data['is_new_image'];
        //$isNewImage1 = $data['is_new_image1'];
        $isNewVideo = $data['is_new_video'];
        if(isset($data['is_home']) && $data['is_home'] == 'on'){
            $data['is_home'] = 1;
        }else{
            $data['is_home'] = 0;
        }
        //$data['ingredients'] = $this->remove_empty($data['ingredients']);

        //$data['ingredients'] = json_encode($data['ingredients']);

        $data = $this->_formatDataToSave($data);

        $data['modified_by'] = \Auth::id();
        $data['date_modified'] = date('Y-m-d H:i:s');

        $tags = isset($data['tags'])?$data['tags']:[];

        $this->filterColumns($data, $object);

        $isSuccess = false;

        DB::transaction(function () use ($tags, $object, &$isSuccess) {
            try {

                $object->save();
                $videoId = $object->{$object->primaryKey};

                // Update video tags
                DB::table('tag_video')->where('video_id', '=', $videoId)->delete();
                foreach($tags as $tagid) {
                    DB::table('tag_video')->insert(['video_id' => $videoId, 'tag_id' => $tagid]);
                }

                DB::commit();
                Session::flash('video-success-message', 'Chỉnh sửa thông tin Video thành công');
                $isSuccess = $videoId;
            } catch (Exception $ex) {
                DB::rollback();
                Session::flash('video-error-message', 'Chỉnh sửa thông tin Video thất bại. Vui lòng thử lại sau.');
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
                $this->delFile($_ENV['MEDIA_PATH_IMAGE'], $old_image);
                $this->saveFile($path, $data['image_name']);
            }

            /*
            if ($isNewImage1) {
                $path = $_ENV['MEDIA_PATH_IMAGE'] . '/' . $folder_image . '/' . $date;
                $dataMedia['background_location'] = $folder_image . '/' . $date . '/' . $data['image_name1'];
                $this->saveFile($path, $data['image_name1']);
            }
            */

            /**
             * upload video
             */
            if ($isNewVideo) {
                $path = $_ENV['MEDIA_PATH_VIDEO']. '/' . $date;
                $dataMedia['video_location'] = $date . '/' . $data['video_name'];
                $this->delFile($_ENV['MEDIA_PATH_VIDEO'], $old_video);
                $this->saveFile($path, $data['video_name']);
            }

            if (count($dataMedia))
                Videos::where('id', $isSuccess)->update($dataMedia);
        }
        return $id;
    }

    /**
     * Enter description here ...
     * @param unknown $data
     * @return unknown
     * @author HaLV
     */
    public function getTopVideoByView() {
        return Videos::where('disable', 0)
        ->orderBy('view_count', 'DESC')->skip(0)->take(10)->get()->toArray();
    }

    /**
     * Enter description here ...
     * @param unknown $data
     * @return unknown
     * @author HaLV
     */
    public function getDataExport() {
        return Videos::select('id', 'name')->get()->toArray();
    }

    /**
     * Enter description here ...
     * @param unknown $data
     * @return unknown
     * @author HaLV
     */
    public function getDataExportTopVideoByView() {
        return Videos::select('name', 'duration', 'view_count')->where('disable', 0)
        ->orderBy('view_count', 'DESC')->skip(0)->take(50)->get()->toArray();
    }

}
