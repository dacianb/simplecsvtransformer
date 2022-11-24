<?php

declare(strict_types=1);
require_once './vendor/autoload.php';


// TODO: Load transformation rules from command line or form .json file
include_once('config.php');

use App\App;

if (php_sapi_name() != 'cli') {
    throw new ErrorException('This application must be run from the command line!');
}

$app = new App(__DIR__, $_transformerRules);

$app->run();
