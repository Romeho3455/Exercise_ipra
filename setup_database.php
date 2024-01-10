<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

// Set the database connection name
$connection = config('database.default');

// Get the database name from the configuration
$database = config("database.connections.{$connection}.database");

// Check if the database exists
if (!DB::statement("CREATE DATABASE IF NOT EXISTS {$database}")) {
    die("Error creating database {$database}\n");
}

// Run migrations
Artisan::call('migrate');

// Run seeders
Artisan::call('db:seed', ['--class' => 'TicketTypeSeeder']);
Artisan::call('db:seed', ['--class' => 'StatusSeeder']);
Artisan::call('db:seed', ['--class' => 'TicketSeeder']);

echo "Database setup and seeded successfully.\n";
