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
