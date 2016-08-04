<?php

namespace App;

use App\Security\TokenAuthenticator;
use Bugsnag\Silex\Provider\BugsnagServiceProvider;
use Moust\Silex\Provider\CacheServiceProvider;
use Silex\Application;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\SecurityServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\SwiftmailerServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\WebProfilerServiceProvider;
use Sorien\Provider\DoctrineProfilerServiceProvider;
use Sorien\Provider\PimpleDumpProvider;
use Symfony\Component\Yaml\Yaml;
use WhoopsSilex\WhoopsServiceProvider;

class App extends Application {
  use \Silex\Application\MonologTrait;

  public $settings;

  function __construct(array $values = []) {
    parent::__construct($values);

    // Load settings.
    $this->settings = Yaml::parse(
      file_get_contents(__DIR__ . '/../config/settings.yml')
    );

    // Register service providers.
    $this->register(new PimpleDumpProvider());
    $this->register(new SwiftmailerServiceProvider());
    $this->register(new WhoopsServiceProvider());
    $this->register(new MonologServiceProvider(), [
        'monolog.logfile' => __DIR__ . '/../storage/log/development.log',
      ]
    );

    // Web profiler.
    $this->register(new HttpFragmentServiceProvider());
    $this->register(new ServiceControllerServiceProvider());
    $this->register(new TwigServiceProvider());
    $this->register(new WebProfilerServiceProvider(), [
        'profiler.cache_dir'    => __DIR__ . '/../storage/cache/profiler',
        'profiler.mount_prefix' => '/_profiler', // this is the default
      ]
    );
    // Doctrine DBAL Profiler.
    $this->register(new DoctrineProfilerServiceProvider());

    // Bugsnag Provider.
    $this->register(new BugsnagServiceProvider(), [
        'bugsnag.options' => [
          'apiKey' => 'b1f8e1e13055db4433ac7da2bca5c3121',
        ],
      ]
    );

    // Cache provider.
    $this->register(new CacheServiceProvider(), [
        'cache.options' => [
          'driver'    => 'file',
          'cache_dir' => __DIR__ . '/../storage/cache',
        ],
      ]
    );

    // Configure database connection.
    $this->register(new DoctrineServiceProvider(), [
        'db.options' => $this->settings['db.options'],
      ]
    );
  }

}
