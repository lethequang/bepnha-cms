<?php

return [
    'maxCommentLevel'  => 2,
    'fullFormatDate'  => 'd-m-Y H:i:s',
    'shortFormatDatePicker' => 'dd-mm-yyyy',
//     'articleFolder' => '/upload/images/articles',
//     'allowUserGroupIDInside' => [STAFF_GROUP_ID_ADMIN, STAFF_GROUP_ID_USER],
//     'general_manager' => [
//         'filter' => [
//             STAFF_GROUP_ID_ADMIN => ['admin'],
//             STAFF_GROUP_ID_USER => ['user'],
//         ]
//     ],
    'bootstrapTable' => [
        'extension' => [
            'cookie' => [
                'cookieExpire' => '8d'
            ]
        ]
    ]
];
