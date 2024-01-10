<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Str;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
     public function run()
      {
          $creators = ['Robert', 'Tadas', 'Gvidas', 'Paulius'];
          $testers = ['Davidas', 'Arturas'];
          $artists = ['Artist1', 'Artist2', 'Artist3', 'Artist4'];

          // Fetch all status and ticket_type IDs from their respective tables
          $statuses = DB::table('statuses')->pluck('id')->toArray();
          $ticketTypes = DB::table('ticket_types')->pluck('id')->toArray();

          // Generate random rows for the tickets table
          for ($i = 0; $i < 20; $i++) {
              DB::table('tickets')->insert([
                  'name' => $this->generateRandomString(12),
                  'content' => $this->generateRandomString(40),
                  'creator' => $creators[array_rand($creators)],
                  'tester' => $testers[array_rand($testers)],
                  'artist' => $artists[array_rand($artists)],
                  'status' => $statuses[array_rand($statuses)],
                  'ticket_type' => $ticketTypes[array_rand($ticketTypes)],
                  'created_at' => now(),
                  'updated_at' => now(),
              ]);
          }
      }

      private function generateRandomString($length)
      {
          return Str::random($length);
      }
}
