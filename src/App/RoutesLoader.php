<?php

namespace App\Routes;

use Silex\Application;
use Symfony\Component\Yaml\Yaml;

class RoutesLoader {

  private $app;
  private $routes;

  const ROUTES_PATH = __DIR__ . '/../../app/config/routes.yml';

  public function __construct(Application $app) {
    $this->app = $app;
    $this->routes = Yaml::parse(file_get_contents(self::ROUTES_PATH));
  }

  public function bindRoutesToControllers() {
    array_walk($this->routes, function ($route, $name) {
      $this->app->match($route['pattern'], $route['defaults']['_controller'])
        ->bind($name)
        ->method($route['method']);
    });
  }
}
