<?php namespace App\Http\Requests\Inside;

use App\Http\Requests\Request;

class ConfigsRequest extends Request {

private $_languages = array();
    public function __construct() {
        $this->_languages = json_decode(LANGUAGES);
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
        $data["config_key"] = 'required';
        return $data;
    }

    public function messages () {
        $data = array();
        $data["config_key.required"] = 'Vui lòng nhập tên key';
        return $data;
    }
}