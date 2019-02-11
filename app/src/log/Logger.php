<?php

namespace Log;

class Logger
{
	public static function log($message)
	{
		echo '----------------------------'.PHP_EOL.$message.PHP_EOL;
	}
}