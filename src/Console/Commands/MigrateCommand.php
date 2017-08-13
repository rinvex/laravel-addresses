<?php

declare(strict_types=1);

namespace Rinvex\Addressable\Console\Commands;

use Illuminate\Console\Command;

class MigrateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rinvex:migrate:addressable';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate Rinvex Addressable Tables.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->warn('Migrate rinvex/addressable:');
        $this->call('migrate', ['--step' => true, '--path' => 'vendor/rinvex/addressable/database/migrations']);
    }
}
