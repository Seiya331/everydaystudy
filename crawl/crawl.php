<?php
require_once 'vendor/autoload.php';
use Goutte\Client;

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
        $crawl->filter( '.recomm >h3 > a' )->each( function ($node) {
            $curren_url = 'http://http://www.oschina.net/'.$node->attr('href');
            $this->__crawlContent($curren_url);
        });
    }

    private function __crawlContent($url)
    {
        $crawl = $this->_getCrawl($url);
        $crawl->filter( '.ProjectNews  > a' )->each( function ($node) {
            $current_url = 'http://http://www.oschina.net/'.$node->attr('href');
            $this->__submit($current_url);
        });

    }

    private function __submit($url){
        $zzName =  pathinfo($url);
        $zzName = $zzName['filename'];
        $params = array('dates' => '20140414', 'o' => '192382', 'o' => '213003');
        $crawler = $this->goutteObj->request('POST', $url, $params);
    }
    private function _getCrawl($url)
    {
        return $this->goutteObj->request( 'GET', $url );
    }

}

$start_url = 'http://www.oschina.net/project/lang/19/java?tag=0&os=0&sort=view&p=';
$crawlObj = new Crawl( $start_url, 2 );
$crawlObj->main();