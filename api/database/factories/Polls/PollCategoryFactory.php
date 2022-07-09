<?php

namespace Database\Polls\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Polls\PollCategory>
 */
class PollCategoryFactory extends Factory
{

    public function definition()
    {
        return [
            'label' => $this->faker->randomLetter(),
        ];
    }

}
