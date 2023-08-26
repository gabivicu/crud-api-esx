<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        $chunks = 60;
        $entriesPerChunk = 1000;

        for ($i = 0; $i < $chunks; $i++) {
            User::factory()->count($entriesPerChunk)->create();
        }
    }
}
