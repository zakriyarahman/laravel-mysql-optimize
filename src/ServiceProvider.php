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
     * Console command classes
     *
     * @var array
     */
    protected $consoleClasses = [
        Zaks\MySQLOptimier\Console\Commands\Command::class,
    ];

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
        return $this->consoleClasses;
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
