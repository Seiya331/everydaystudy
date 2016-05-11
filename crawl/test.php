<?php
/**
 * Created by PhpStorm.
 * User: zhuguojie
 * Date: 16/5/11
 * Time: 上午10:45
 */
require_once 'vendor/autoload.php';
use Goutte\Client;

class  Crawl
{
    private $goutteObj;
    private $startUrl = '';
    private $pages = 1;

    public function __construct($startUrl = '', $pages = '')
    {
        $this->goutteObj = new Client();
        $this->startUrl = $startUrl;
        $this->pages = $pages;
    }

    public function main()
    {

        $client = new \GuzzleHttp\Client();
        $response = $client->request('post', 'http://git.gz.com/crawl/down.php');
        $info = $response->getBody();
        file_put_contents('./my/test.torrent',$info);
    }


}

$crawl = new Crawl();
$crawl->main();