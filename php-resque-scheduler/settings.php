<?php

require 'vendor/autoload.php';

$settings = [
	'REDIS_BACKEND'     => '127.0.0.1:6379',    // Set Redis Backend Info
	'REDIS_BACKEND_DB'  => '0',                 // Use Redis DB 0
	'COUNT'             => '10',                 // Run 1 worker
	'INTERVAL'          => '1',                 // Run every 5 seconds
	'QUEUE'             => 'test',                 // Look in all queues
	'PREFIX'            => '',              // Prefix queues with test
	'VVERBOSE' 			=> 0,
	'VERBOSE' => 0
];
if(!empty(getenv('QUEUE'))){
	$settings['QUEUE'] = getenv('QUEUE');
}
foreach ($settings as $key => $value) {
	putenv(sprintf('%s=%s', $key, $value));
}