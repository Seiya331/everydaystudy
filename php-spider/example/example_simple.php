<?php

use VDB\Spider\Discoverer\XPathExpressionDiscoverer;
use Symfony\Component\EventDispatcher\Event;
use VDB\Spider\Event\SpiderEvents;
use VDB\Spider\StatsHandler;
use VDB\Spider\Spider;

require_once __DIR__ . '/../vendor/autoload.php';

// Create Spider
$url = 'http://laravelacademy.org/page/1';
class Crawl
{
    public function crawlOnePage($url)
    {

        $spider = new Spider($url);
        $spider->getDiscovererSet()->set(new XPathExpressionDiscoverer("//h2[@class='entry-title']//a"));

        $spider->getDiscovererSet()->maxDepth = 1;
        $spider->getQueueManager()->maxQueueSize = 10;

        $statsHandler = new StatsHandler();
        $spider->getQueueManager()->getDispatcher()->addSubscriber($statsHandler);
        $spider->getDispatcher()->addSubscriber($statsHandler);

        $spider->crawl();

        foreach ($spider->getDownloader()->getPersistenceHandler() as $resource) {
            $datas = $resource->getCrawler()
                ->filterXpath("//[@class='size-full']")
                ->each(function($node, $i){
                    return $node->attr('src');
                });

            foreach ($datas as $data) {
                echo $data."\n";
            }

            // echo "\n - " . $resource->getCrawler()->filterXpath('//title')->text();
        }

    }


    public function  start(){
        for ($i=1; $i <10 ; $i++) { 
            $url = 'http://laravelacademy.org/page/'.$i;
            echo "开始第".$i.'页';
            $this->crawlOnePage($url);
        }
    }

}

$crawlObj = new Crawl();
$crawlObj ->start();
