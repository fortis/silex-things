<?php

namespace App\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Response;

class HomeController {

  public function indexAction(Application $app) {
    return $app['twig']->render('index.twig', array(
      'title' => 'It works!',
      'content' => 'Some piece of text',
    ));
  }

}
