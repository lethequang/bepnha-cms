<?php namespace App\Http\Requests\Inside;

use App\Http\Requests\Request;

class VideosRequest extends Request {

private $_languages = array();
public function __construct() {

    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        $data = array();
        $data['video_name']         = 'required';
        $data['name']               = 'required';
        $data['duration']           = 'required';
        $data['category_id']           = 'required';
        $data['image_name']         = 'required';
        //$data['image_name1']         = 'required';

        return $data;
    }

    public function messages() {
        $data = array();
        $data["video_name.required"]    = 'Vui lòng chọn Video tải lên.';
        $data["name.required"]          = 'Vui lòng nhập tên Video.';
        $data["duration.required"]      = 'Vui lòng nhập thời gian Video.';
        $data["category_id.required"]      = 'Vui lòng chọn Category.';
        $data["image_name.required"]    = 'Vui lòng chọn Image Cover.';
        //$data["image_name1.required"]    = 'Vui lòng chọn Image Background.';
        return $data;
    }
}