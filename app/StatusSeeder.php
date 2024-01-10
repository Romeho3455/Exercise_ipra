<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
     public function run()
     {
         // Insert default statuses
         DB::table('statuses')->insert([
             ['name' => 'Paused'],
             ['name' => 'In Progress'],
             ['name' => 'Testing'],
             ['name' => 'Release'],
         ]);
     }
}
