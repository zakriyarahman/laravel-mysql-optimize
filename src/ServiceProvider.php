<?php

namespace Zaks\MySQLOptimier;

use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\ServiceProvider as AbstractServiceProvider;
use Zaks\MySQLOptimier\Console\Commands\Command;

class ServiceProvider extends AbstractServiceProvider
{
    /**
     * Config Name
     *
     * @var string
     */
    protected string $config = 'mysql-optimizer';

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind('zpdo', function($app) {
            $dbaName = config($this->config . '.databaseName');
            $dbaHost = config($this->config . '.databaseHost');
            $dbaUsername = config($this->config . '.databaseUsername');
            $dbaPassword = config($this->config . '.databasePassword');
            return new ZPDO('mysql:dbname=' . $dbaName . ';host=' . $dbaHost, $dbaUsername, $dbaPassword);
        });
        $this->commands([Command::class]);
    }

    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot(): void
    {
        $source = realpath($raw = __DIR__."/../config/{$this->config}.php") ?: $raw;

        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([$source => config_path("$this->config.php")]);
        } elseif ($this->app instanceof LumenApplication) {
            $this->app->configure($this->config);
        }

        $this->mergeConfigFrom($source, $this->config);
    }
}
