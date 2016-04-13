<?php

class Job
{
	public function perform()
	{
		try {
			fwrite(STDOUT, 'Start job! -> ');
			fwrite(STDOUT, time() . PHP_EOL);
//			$fp = fopen('a.txt','a+');
//			fwrite($fp,time().PHP_EOL);
//			fclose($fp);
			fwrite(STDOUT, 'Job ended!' . PHP_EOL);


		} catch (\Exception $e) {
			echo $e->getMessage();
		}
	}
}