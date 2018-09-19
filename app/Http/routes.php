<?php

use \Illuminate\Support\Facades\DB;

Route::get('/viewlogfile', function () {
    return file_get_contents('../storage/logs/laravel.log');
});

//Route::group(['domain' => env('DOMAIN_NAME_CMS')], function () {
    Route::get('/','Inside\IndexController@getIndex');
    Route::controller('/inside/index',              'Inside\IndexController');
    Route::controller('/inside/users',              'Inside\UsersController');
    Route::controller('/inside/static',             'Inside\StaticController');
    Route::controller('/inside/configs',            'Inside\ConfigsController');
    Route::controller('/inside/groups',             'Inside\GroupsController');
    Route::controller('/inside/staffs',             'Inside\StaffsController');
    Route::controller('/inside/categories',         'Inside\CategoriesController');
    Route::controller('/inside/videos',             'Inside\VideosController');
    Route::controller('/inside/tags',               'Inside\TagsController');
    Route::controller('/inside/tag-groups',         'Inside\TagGroupsController');
    Route::controller('/inside/notebook',           'Inside\NoteBookController');
//});