<?php
/**
 * Created by PhpStorm.
 * User: zhuguojie
 * Date: 16/5/11
 * Time: 上午10:46
 */
$hanle = fopen('a.txt','a+');

fwrite($hanle,time().PHP_EOL);
header("Content-Type: application/octet-stream");

$quan=rand(999,10000000);
$filename = "100yuan.txt";
$encoded_filename = urlencode($filename);
$encoded_filename = str_replace("+", "%20", $encoded_filename);

header('Content-Disposition: attachment; filename="' .  $filename . '"');

echo file_get_contents('./O6YFF5a.torrent');