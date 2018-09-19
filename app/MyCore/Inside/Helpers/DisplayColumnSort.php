<?php namespace App\MyCore\Inside\Helpers;

class DisplayColumnSort {
    public static function show($columnName = '') {
        $columnName = $columnName . '_sort';
        $params = \Request::all();

        $styleSortUp   = 'position: absolute; bottom: 6px; width: 17px; height: 10px;';
        $styleSortDown = 'position: absolute; top: -6px; width: 17px; height: 10px;';

        $urlSortUp   = '';
        $urlSortDown = '';

        $paramsSortUp   = array($columnName => 'ASC');
        $paramsSortDown = array($columnName => 'DESC');

        $paramsSortUp = $paramsSortUp + $params;
        $paramsSortDown = $paramsSortDown + $params;

        if (isset($params[$columnName])) {
            if ($params[$columnName] === 'ASC') {
                $styleSortUp   .= 'color: #ccc;';
                $paramsSortUp[$columnName] = null;
            } elseif ($params[$columnName] === 'DESC') {
                $styleSortDown   .= 'color: #ccc;';
                $paramsSortDown[$columnName] = null;
            }
        }

        $urlSortUp = url(\Request::path(), [], false) . '?' . http_build_query($paramsSortUp);
        $urlSortDown = url(\Request::path(), [], false) . '?' . http_build_query($paramsSortDown);

        echo '<div style="position: relative;float: right;margin: 12px;">';
        echo '<a href="' . $urlSortUp . '" style="' . $styleSortUp . '"><span class="order dropup"><span class="caret" style="margin: 10px 5px;"></span></span></a>';
        echo '<a href="' . $urlSortDown . '" style="' . $styleSortDown . '"><span class="order"><span class="caret" style="margin: 10px 5px;"></span></span></a>';
        echo "</div>";
    }
}