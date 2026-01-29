<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DevReset extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dev:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'DEV Only: Refresh, seed DB and process queued jobs';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        if (! app()->environment(['local'])) {
            $this->error('This command can only be run in local env.');
            return Command::FAILURE;
        }

        $this->info('Starting development environment reset...');

        $this->info('Running migrations...');
        $this->call('migrate:fresh', [
            '--force' => true
        ]);

        $this->info('Seeding the database...');
        $this->call('db:seed', [
            '--force' => true
        ]);

        $this->info('Starting queue worker...');
        $this->call('queue:work', [
            '--tries' => 3,
            '--timeout' => 90,
            '--sleep' => 1,
        ]);

        $this->info('Development environment reset complete.');
        return Command::SUCCESS;
    }
}
