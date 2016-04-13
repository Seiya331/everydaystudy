<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 16-2-23
 * Time: 下午1:09
 */
require 'vendor/autoload.php';

if (isset($argv[1])) {
	for($i=0;$i<1000;$i++) {
		$fp = fopen('b.txt','a+');
		fwrite($fp,time().PHP_EOL);
		fclose($fp);
		ResqueScheduler::enqueueIn(1, "test", 'Job', [
				'username' => $argv[1].$i
		]);
		//sleep(1);
		echo "Queued job";
	}
}
else {
	echo 'Please pass a github username to the script such as `php basic_task.php dansackett`';
}