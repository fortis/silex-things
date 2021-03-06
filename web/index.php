<?php

require_once __DIR__.'/../vendor/autoload.php';

use App\App;
use App\Routes\RoutesLoader;

$app = new App();
$app['debug'] = true;

$routesLoader = new RoutesLoader($app);
$routesLoader->bindRoutesToControllers();

// Here we go!
$app->run();
