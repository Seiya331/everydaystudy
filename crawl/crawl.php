<?php
require_once 'vendor/autoload.php';
use Goutte\Client;
set_time_limit(0);
class  Crawl
{
    private $goutteObj;
    private $startUrl = '';
    private $pages = 1;

    public function __construct($startUrl, $pages)
    {
        $this->goutteObj = new Client();
        $this->startUrl = $startUrl;
        $this->pages = $pages;
    }

    public function main()
    {
        if ( $this->pages > 0 ) {
            for ( $i = 1; $i <= $this->pages; $i++ ) {
                $url = $this->startUrl . $i;
                $this->_getAllUrls( $url );

            }
        }
    }

    private function _getAllUrls($url)
    {
        $crawl = $this->_getCrawl( $url );
        $crawl->filter( 'h3 > a' )->each( function ($node) {
            $text = $node -> text();
            if(strpos($text,'国产')) {
                $curren_url = 'http://dtt.pirate1024.net/pw/' . $node->attr( 'href' );
                $this->__crawlContent( $curren_url );
            }
        });
    }

    private function __crawlContent($url)
    {
        $crawl = $this->_getCrawl($url);
        $crawl->filter( '#read_tpc  > a' )->each( function ($node) {
            $current_url = $node->attr('href');
            if(strpos($current_url,'jjyyfsdowns')) {
                $this->__submit( $current_url );
            }
        });

    }

    private function __submit($url){
        $zzName =  pathinfo($url);
        $zzName = $zzName['filename'];
        print('获取'.$url.PHP_EOL);
        $params = array('type'=>'torrent', 'id'=>$zzName, 'name'=>$zzName);
        $client = new \GuzzleHttp\Client();
        $response = $client->request('post', 'http://www1.jjyyfsdowns.net/freeone/down.php',$params);
        $info = $response->getBody();
        $filename= './my/'.$zzName.'.torrent';
        file_put_contents($filename,$info);
        print('保存'.$filename.PHP_EOL);
    }
    private function _getCrawl($url)
    {
        return $this->goutteObj->request( 'GET', $url );
    }

}

$start_url = 'http://dtt.pirate1024.net/pw/thread.php?fid=3&page=';
$crawlObj = new Crawl( $start_url, 2);
$crawlObj->main();