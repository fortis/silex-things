<?php

namespace App\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Response;

class HomeController {

  public function indexAction(Application $app) {
    return new Response('It works!', 200);
  }

}
