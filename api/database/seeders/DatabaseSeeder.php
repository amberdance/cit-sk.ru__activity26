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
        PollFactory::politics();
        PollFactory::transport();
        PollFactory::traveling();
        // PollFactory::testPoll();
        // PollQuestion::factory()->count(2)->has(PollVariant::factory()->count(4), 'variants')->create();
    }
}
