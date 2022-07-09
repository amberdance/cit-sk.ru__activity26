<?php

namespace Database\Seeders;

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
        $this->call([
            \App\Models\Polls\Poll::factory(10)->create(),
            \App\Models\Polls\PollCategory::factory(10)->create(),
        ]);
    }

}
