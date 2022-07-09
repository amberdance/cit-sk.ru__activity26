<?php

namespace Database\Factories\Polls;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PollCategoryFactory extends Factory
{
    protected static function newFactory()
    {
        return PollCategoryFactory::new ();
    }

    public function definition()
    {
        return [
            'label' => $this->faker->sentence(1),
        ];
    }
}
