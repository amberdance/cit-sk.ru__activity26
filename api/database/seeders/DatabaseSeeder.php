<?php

namespace Database\Seeders;

use App\Models\Polls\PollQuestion;
use App\Models\Polls\PollVariant;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        PollQuestion::factory()->count(4)->has(PollVariant::factory()->count(4), 'variants')->create();
    }

}
