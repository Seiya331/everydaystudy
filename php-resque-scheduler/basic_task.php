<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 16-2-23
 * Time: 下午12:25
 */


require 'vendor/autoload.php';

if (isset($argv[1])) {
	echo microtime(true);
	for($i=1;$i<1000;$i++) {
		$id = Resque::enqueue('test', 'Job', [
				'username' => $argv[1]
		], true);
	}
	echo 'Queued job end ' . $id;
}
else {
	echo 'Please pass a github username to the script such as `php basic_task.php dansackett`';
}