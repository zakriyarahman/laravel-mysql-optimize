<?php

namespace Zaks\MySQLOptimier;

use Illuminate\Support\ServiceProvider as AbstractServiceProvider;

class ServiceProvider extends AbstractServiceProvider
{
    /**
     * The paths that should be published.
     *
     * @var array
     */
    public static $publishes = [];

    /**
     * The paths that should be published by group.
     *
     * @var array
     */
    public static $publishGroups = [];

    /**
     * Base package path
     *
     * @var string
     */
    protected $baseDir = __DIR__.'/../';

    /**
     * Config Name
     *
     * @var string
     */
    protected $config = 'mysql-optimizer';

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Setup the config
        $path = $this->baseDir.'config'.'/';
        $file = $this->config.'.php';
        $this->mergeConfigFrom($path.$file, $this->config);
        // Add commands
        $this->commands($this->getCommandClassList());
    }

    /**
     * Get the list of classes in the command file path
     *
     * @return array
     */
    private function getCommandClassList()
    {
        $classes = [];
        foreach (glob(__DIR__.'/Console/Commands/*.php') as $file) {
            require_once $file;
            // get the file name of the current file without the extension
            // which is essentially the class name
            $class = basename($file, '.php');

            if (class_exists($class)) {
                $classes[] = $class;
            }
        }
        return $classes;
    }

    /**
     * Merge the given configuration with the existing configuration.
     *
     * @param  string  $path
     * @param  string  $key
     * @return void
     */
    protected function mergeConfigFrom($path, $key)
    {
        $config = $this->app['config']->get($key, []);

        $this->app['config']->set($key, array_merge(require $path, $config));
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Publish config
        $this->publishConfig();
    }

    /**
     * Publish Config
     *
     * @return Void
     */
    protected function publishConfig()
    {
        # Publish configs
        $this->publishes([
            $this->baseDir . "config/{$this->config}.php" => config_path($this->config),
        ], 'config');
    }
}
