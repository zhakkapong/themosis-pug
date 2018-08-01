<?php

namespace Zhakkapong\ThemosisPug;

use Themosis\Facades\Config;

class PugService extends \Bkwld\LaravelPug\ServiceProvider
{
  public function version ()
  {
    $themosis = $GLOBALS['themosis'];
    return $themosis::VERSION;
  }

  public function boot ()
  {
    $this->registerPugCompiler();
  }

  public function getConfig()
  {
    $options = require(__DIR__ . '/config/config.php');
    try {
      $configs = Config::get('pug');
    } catch (\Exception $e) {
      $configs = [];
    }
    return array_merge($options, $configs);
  }

  protected function getDefaultCache()
  {
    return $this->app['path.storage'].'pug';
  }

  protected function getCompilerCreator($compilerClass)
  {
    return function ($app) use ($compilerClass) {
      return new $compilerClass(
        array($app, 'laravel-pug.pug'),
        $app['filesystem'],
        $this->getConfig(),
        $this->getDefaultCache()
      );
    };
  }
}
