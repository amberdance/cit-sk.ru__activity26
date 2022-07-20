<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Factories\Polls\PollFactory;
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
        User::factory()->create();
        PollFactory::createPoliticsPoll();
        PollFactory::createTestPoll();
        // PollQuestion::factory()->count(2)->has(PollVariant::factory()->count(4), 'variants')->create();
    }
}
