<?php

declare(strict_types=1);

namespace Rinvex\Addresses\Providers;

use Rinvex\Addresses\Models\Address;
use Illuminate\Support\ServiceProvider;
use Rinvex\Support\Traits\ConsoleTools;
use Rinvex\Addresses\Console\Commands\MigrateCommand;
use Rinvex\Addresses\Console\Commands\PublishCommand;
use Rinvex\Addresses\Console\Commands\RollbackCommand;

class AddressesServiceProvider extends ServiceProvider
{
    use ConsoleTools;

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
        $this->registerCommands($this->commands);
    }

    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        // Publish Resources
        $this->publishesConfig('rinvex/laravel-addresses');
        $this->publishesMigrations('rinvex/laravel-addresses');
        ! $this->autoloadMigrations('rinvex/laravel-addresses') || $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
    }
}
