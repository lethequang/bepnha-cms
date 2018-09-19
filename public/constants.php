<?php

/**
 * debug tools
 */
define ( 'REQUEST_MICROTIME', microtime ( true ) );

/**
 * pagination
 */
define ( 'PAGE_LIST_COUNT', 20 );
define ( 'PAGE_LIST_RANGE', 5 );

define ('LANGUAGES', json_encode(array(
    'vi' => 'Tiếng Việt',
    'en' => 'Tiếng Anh'
)));

define('STAFF_GROUP_ID_ADMIN', 1);
define('STAFF_GROUP_ID_USER', 2);
