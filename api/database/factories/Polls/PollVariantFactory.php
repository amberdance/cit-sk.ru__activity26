<?php

namespace Database\Factories\Polls;

use App\Models\Polls\PollQuestion;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PollVariantFactory extends Factory
{
    protected static function newFactory()
    {
        return PollVariantFactory::new ();
    }

    public function definition()
    {
        return [
            'label'       => $this->faker->text,
            'question_id' => PollQuestion::factory(),
        ];
    }
}
