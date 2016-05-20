<?php
require_once 'vendor/autoload.php';
use Goutte\Client;
set_time_limit(0);
class  Crawl
{
    private $goutteObj;
    private $startUrl = '';
    private $pages = 1;
    private $startPage;

    public function __construct($startUrl,$start_page, $pages)
    {
        $this->goutteObj = new Client();
        $this->startUrl = $startUrl;
        $this->pages = $pages;
        $this->startPage = $start_page;
    }

    /**
     * main 代码
     */
    public function main()
    {
        if ( $this->pages > 0 ) {
            for ( $i = $this->startPage; $i <= $this->pages; $i++ ) {
                echo '第'.$i.'页'.PHP_EOL;
                $url = $this->startUrl . $i;
                $this->getAllUrls( $url );

            }
        }
    }

    private function getAllUrls($url)
    {
        $crawl = $this->getCrawl( $url );
        $crawl->filter( 'h3 > a' )->each( function ($node) {
            $text = $node -> text();
            //if(strpos($text,'11') || strpos($text,'dd')) {
            if(strpos($text,'国产') || strpos($text,'國產')) {
                $current_url = 'http://dtt.pirate1024.net/pw/' . $node->attr( 'href' );
                echo '获取url'.$current_url.PHP_EOL;
                $this->crawlContent( $current_url );
            }
        });
    }

    private function crawlContent($url)
    {
        $crawl = $this->getCrawl($url);
        $crawl->filter( '#read_tpc  > a' )->each( function ($node) {
            $current_url = $node->attr('href');
            if(strpos($current_url,'jjyyfsdowns')) {
                $this->saveUrls( $current_url );
            }
        });

    }

    private function getCrawl($url)
    {
        return $this->goutteObj->request( 'GET', $url );
    }

    /**
     * 保存文件
     * @param $url
     */
    private function saveUrls($url){
        $handle = fopen('urls.txt','a+');
        fwrite( $handle,$url .PHP_EOL  );
    }
    private function submit($url){
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


}

$start_url = 'http://dtt.pirate1024.net/pw/thread.php?fid=3&page=';
$crawlObj = new Crawl( $start_url, 3,40);
$crawlObj->main();
#$crawlObj = new Crawl( $start_url, 3,4);
#$crawlObj->main();
#$crawlObj = new Crawl( $start_url, 5,6);
#$crawlObj->main();