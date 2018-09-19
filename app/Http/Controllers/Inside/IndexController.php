<?php

namespace App\Http\Controllers\Inside;

use App\MyCore\Inside\Routing\MyController;

class IndexController extends MyController {

    private $_model = null;
    private $_params = array();
    public function __construct() {
        $options = array();
        $this->_params = \Request::all();
        $this->data['params'] = $this->_params;
        parent::__construct($options);

        $this->data['title']          = 'Inside';
        $this->data['controllerName'] = 'index';
    }

    public function getIndex() {
        return redirect("{$this->data['moduleName']}/users/dashboard");
    }

    public function getTest() {
    }
}
