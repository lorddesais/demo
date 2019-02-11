<?php

define('APP_ROOT', dirname(__FILE__));

require 'vendor/autoload.php';
require 'src/App.php';

$app = new App($argv);

$app->run();

