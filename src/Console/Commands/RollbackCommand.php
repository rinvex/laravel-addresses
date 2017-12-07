<?php

declare(strict_types=1);

namespace Rinvex\Addresses\Console\Commands;

use Illuminate\Console\Command;

class RollbackCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rinvex:rollback:addresses';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rollback Rinvex Addresses Tables.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->warn($this->description);
        $this->call('migrate:reset', ['--path' => 'vendor/rinvex/addresses/database/migrations']);
    }
}
