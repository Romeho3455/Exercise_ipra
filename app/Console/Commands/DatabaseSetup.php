<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class DatabaseSetup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create database and run migrations';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
      $databaseName = config('database.connections.mysql.database');

         // Run migrations
         $this->call('migrate');

         // Seed data
         $this->call('db:seed');

         $this->call('db:seed', ['--class' => 'TicketTypeSeeder']);
         $this->call('db:seed', ['--class' => 'StatusSeeder']);
         $this->call('db:seed', ['--class' => 'TicketSeeder']);

         $this->info('Database setup completed successfully.');
    }
}
