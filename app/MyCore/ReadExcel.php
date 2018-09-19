<?php

/**
 * Created by PhpStorm.
 * User: giaulk
 * Date: 4/21/2016
 * Time: 9:43 AM
 */
namespace App\MyCore;

require_once dirname(__FILE__) . '/PHPExcel/Classes/PHPExcel.php';

class ReadExcel {
    public static function readExcel($file) {
        $inputFileType = \PHPExcel_IOFactory::identify($file->getPathname());

        $objReader = \PHPExcel_IOFactory::createReader($inputFileType);

        $objReader->setReadDataOnly(true);

        $objPHPExcel = $objReader->load($file->getPathname());


        $objWorksheet  = $objPHPExcel->setActiveSheetIndex(0);
        $highestRow    = $objWorksheet->getHighestRow();
        $highestColumn = $objWorksheet->getHighestColumn();
        $highestColumnIndex = \PHPExcel_Cell::columnIndexFromString($highestColumn);
        $data = array();
        for ($row = 4; $row <= $highestRow; ++$row) {
            for ($col = 0; $col < $highestColumnIndex; ++$col) {
                $value = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
                $data[$row - 2][$col] = $value;
            }
        }

        return $data;
    }
}