<?php

namespace Database\Polls\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Polls\Poll>
 */
class PollFactory extends Factory
{

    public function definition()
    {
        return [
            'category_id' => $this->faker->randomNumber(100),
            'label'       => $this->faker->randomLetter(),
            'description' => $this->faker->randomHtml(),
            'is_active'   => 1,
        ];
    }

}
