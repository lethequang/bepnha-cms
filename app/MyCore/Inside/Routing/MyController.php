<?php

namespace App\MyCore\Inside\Routing;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Controllers\Inside\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Route;
use App\Http\Models\Inside\Staff;

class MyController extends Controller {

    public $data    = array();
    public $request = null;
    public $user    = null;
    public function __construct($options = array()) {

        $action = app('request')->route()->getAction();
        $controller = class_basename($action['controller']);

        list($controller, $action)    = explode('@', $controller);

        $this->data['moduleName']     = 'inside';

        $this->data['controllerNameDefault'] = $action;
        $this->data['actionNameDefault'] = $action;
        if (!Auth::check()
            && !in_array($action, array('getLogin', 'postLogin'))) {
            header("Location: /{$this->data['moduleName']}/users/login");
            exit();
        }

        $this->user = Auth::user();

        $this->data['user'] = $this->user;

        if (!empty($this->data['user'])) {
            $this->data['manageStaff'] = $this->user->group === Staff::GROUP_ADMIN;
        }
    }

    public function toKeyPairs($key, $data){
        $result = array();
        for($i = 0; $i < count($data); $i++) {
            $current = $data[$i];
            $ckey = $current->{$key};
            unset($current->{$key});
            $result[$ckey] = $current;
        }
        return $result;
    }

    /**
     * push data xuống view
     *
     * @return mixed
     * @author
     */
    public function buildDataView($data = array()) {
        extract($data);
        return compact(array_keys($data));
    }
}
