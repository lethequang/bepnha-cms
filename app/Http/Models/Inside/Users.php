<?php namespace App\Http\Models\Inside;

use App\MyCore\Inside\Models\DbTable;
use App\Http\Requests\UsersRequest;
use Illuminate\Auth\Authenticatable;
use DB;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class Users extends DbTable implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract {

    use Authenticatable,
        Authorizable,
        CanResetPassword;

    public $primaryKey = 'user_id';
    
    public function __construct($options = array()) {
        parent::__construct($options);

        $this->table = 'users';
        $this->fillable = ['is_deleted'];

        $this->searchs = array(
            'email_search' => "email"
        );

        $this->sorts = array(
            'email_sort'    => "email",
            'user_type_sort'      => "user_type",
            'date_created_sort'    => "date_created",
            'is_deleted_sort'      => "is_deleted",
        );

        $this->filters = array(
            'is_deleted_filter' => "is_deleted",
        );
        
        $this->params = \Request::all();
    }

    /**
     * Lấy thông tin user theo email
     *
     * @param $email
     * @return mixed
     */
    public function getUserByEmail($email) {
        return Users::where('email', '=', $email)
            ->first();
    }
}
