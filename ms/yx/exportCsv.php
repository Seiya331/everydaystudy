<?php
/**
 * 此题目是去优信而二手车时候遇到的
 * Created by PhpStorm.
 * User: guojiezhu
 * Date: 16/4/11下午3:10
 */

/**
 * 导出csv
 *
 */

class exportCsv
{
    public static function export(){

        self::doExport(date('ymd').'.csv');
        $fp = fopen('php://output', 'a');
        for($i=1;$i<1000000;$i++) {
            $array = range(0,9);
            shuffle($array);
            fputcsv($fp, $array);
        }

    }

    protected static function doExport($filename)
    {
        header("Content-type:text/csv");
        header("Content-Disposition:attachment;filename=" . $filename);
        header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
        header('Expires:0');
        header('Pragma:public');
    }

    public static function start()
    {
        return memory_get_usage();
    }

    public static function end()
    {
        return memory_get_usage();
    }
}
//导出数据,增加内存消耗
$return = exportCsv::start();
exportCsv::export();
$return_end = exportCsv::end();
file_put_contents('a.txt',($return_end-$return));