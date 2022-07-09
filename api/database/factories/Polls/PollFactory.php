<?php

namespace Database\Factories\Polls;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PollFactory extends Factory
{

    protected static function newFactory()
    {
        return PollFactory::new ();
    }

    public function definition()
    {
        return [
            'label'       => $this->faker->sentence(),
            'description' => $this->faker->text(rand(10, 100)),
            'category_id' => rand(1, 10),
            'image'       => 'images/polls/' . array_values(array_diff(scandir(__DIR__ . "/../../../public/assets/images/polls/"), [".", ".."]))[rand(0, 4)],
        ];
    }
}
