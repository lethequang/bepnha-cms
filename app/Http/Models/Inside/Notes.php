<?php namespace App\Http\Models\Inside;
/**
 * Created by PhpStorm.
 * User: Elegant
 * Date: 13/12/2016
 * Time: 10:56 SA
 */

use App\MyCore\Inside\Models\DbTable;
use DB;
use Session;

class Notes extends DbTable {
    protected $table = 'tag_group';
    public function __construct($options = array()) {
        parent::__construct($options);
    }

}