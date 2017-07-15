<?php

declare(strict_types=1);

namespace Rinvex\Addressable;

use Illuminate\Support\ServiceProvider;

class AddressableServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function register()
    {
        // Merge config
        $this->mergeConfigFrom(realpath(__DIR__.'/../config/config.php'), 'rinvex.addressable');
    }

    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            // Load migrations
            $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

            // Publish Resources
            $this->publishResources();
        }
    }

    /**
     * Publish resources.
     *
     * @return void
     */
    protected function publishResources()
    {
        $this->publishes([realpath(__DIR__.'/../config/config.php') => config_path('rinvex.addressable.php')], 'rinvex-addressable-config');
        $this->publishes([realpath(__DIR__.'/../database/migrations') => database_path('migrations')], 'rinvex-addressable-migrations');
    }
}
