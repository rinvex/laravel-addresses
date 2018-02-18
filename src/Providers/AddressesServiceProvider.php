<?php

declare(strict_types=1);

namespace Rinvex\Addresses\Providers;

use Rinvex\Addresses\Models\Address;
use Illuminate\Support\ServiceProvider;
use Rinvex\Addresses\Console\Commands\MigrateCommand;
use Rinvex\Addresses\Console\Commands\PublishCommand;
use Rinvex\Addresses\Console\Commands\RollbackCommand;

class AddressesServiceProvider extends ServiceProvider
{
    /**
     * The commands to be registered.
     *
     * @var array
     */
    protected $commands = [
        MigrateCommand::class => 'command.rinvex.addresses.migrate',
        PublishCommand::class => 'command.rinvex.addresses.publish',
        RollbackCommand::class => 'command.rinvex.addresses.rollback',
    ];

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        // Merge config
        $this->mergeConfigFrom(realpath(__DIR__.'/../../config/config.php'), 'rinvex.addresses');

        // Bind eloquent models to IoC container
        $this->app->singleton('rinvex.addresses.address', $addressModel = $this->app['config']['rinvex.addresses.models.address']);
        $addressModel === Address::class || $this->app->alias('rinvex.addresses.address', Address::class);

        // Register console commands
        ! $this->app->runningInConsole() || $this->registerCommands();
    }

    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        // Load migrations
        ! $this->app->runningInConsole() || $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');

        // Publish Resources
        ! $this->app->runningInConsole() || $this->publishResources();
    }

    /**
     * Publish resources.
     *
     * @return void
     */
    protected function publishResources(): void
    {
        $this->publishes([realpath(__DIR__.'/../../config/config.php') => config_path('rinvex.addresses.php')], 'rinvex-addresses-config');
        $this->publishes([realpath(__DIR__.'/../../database/migrations') => database_path('migrations')], 'rinvex-addresses-migrations');
    }

    /**
     * Register console commands.
     *
     * @return void
     */
    protected function registerCommands(): void
    {
        // Register artisan commands
        foreach ($this->commands as $key => $value) {
            $this->app->singleton($value, $key);
        }

        $this->commands(array_values($this->commands));
    }
}
