<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RefreshDatabaseWithSeedAndIseed extends Command
{
    protected $signature = 'db:refresh-iseed';

    protected $description = 'Refresh the database, run iseed, and seed data';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Run iseed command
        $this->call('iseed', ['tables' => 'translators']);

        // Run migrate:fresh command with seed
        // $this->call('migrate:fresh', ['--seed' => true]);
    }
}