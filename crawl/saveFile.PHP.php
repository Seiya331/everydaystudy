<?php
/**
 * Created by PhpStorm.
 * User: zhuguojie
 * Date: 16/5/12
 * Time: 下午10:36

 *
 */

$handle = fopen('urls.txt','r');
while($row = fgets( $handle )){
    $zzName =  pathinfo($url);
    $zzName = $zzName['filename'];
    print('获取'.$url.PHP_EOL);
    $params = array('type'=>'torrent', 'id'=>$zzName, 'name'=>$zzName);
    $client = new \GuzzleHttp\Client();
    $response = $client->request('post', 'http://www1.jjyyfsdowns.net/freeone/down.php',$params, ['debug' => true,'timeout'=>2]);
    $info = $response->getBody();
    $filename= './my/'.$zzName.'.torrent';
    if(!file_exists($filename)) {
        file_put_contents( $filename, $info );
        print('保存' . $filename . PHP_EOL);
    }else{
        echo $filename.'已存在'.PHP_EOL;
    }
}
