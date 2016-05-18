<?php
require_once 'vendor/autoload.php';
use Goutte\Client;

set_time_limit( 0 );

class  Crawl
{
    private $goutteObj;
    private $startUrl = '';
    private $pages = 1;
    private $startPage;

    public function __construct($startUrl, $start_page, $pages)
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
                echo '第' . $i . '页' . PHP_EOL;
                $url = $this->startUrl . $i;
                $this->_getAllUrls( $url );

            }
        }
    }

    private function _getAllUrls($url)
    {
        $crawl = $this->_getCrawl( $url );
        $crawl->filter( '.entry-title > a' )->each( function ($node) {
            $current_url = $node->attr( 'href' );
            echo '获取url' . $current_url . PHP_EOL;
            usleep( 10000 );
            $this->__crawlContent( $current_url );
        } );
    }

    private function _getCrawl($url)
    {
        return $this->goutteObj->request( 'GET', $url );
    }

    private function __crawlContent($url)
    {
        $crawlObj = $this->_getCrawl( $url );
        $crawlObj->filter( '#ipt-kb-affix-active-post > a' )->each( function ($node) {
            $current_url = $node->attr( 'href' );
            echo $current_url. PHP_EOL;
        } );

    }

}

$start_url = 'http://laravelacademy.org/page/';
$crawlObj = new Crawl( $start_url, 1, 2 );
$crawlObj->main();
