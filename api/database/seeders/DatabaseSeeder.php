<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Factories\DistrictsFactory;
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
        // User::factory()->create();
        // PollFactory::politics();
        // PollFactory::comfortableCity();
        // PollFactory::traveling();
        // PollFactory::transport();
        DistrictsFactory::fillDistricts();
    }
}
