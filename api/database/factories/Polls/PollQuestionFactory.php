<?php

namespace Database\Factories\Polls;

use App\Models\Polls\Poll;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PollQuestionFactory extends Factory
{
    protected static function newFactory()
    {
        return PollQuestionFactory::new ();
    }

    public function definition()
    {
        return [
            'poll_id'         => Poll::factory(),
            'label'           => 'Test question',
            'type'            => Arr::random(['radio', 'checkbox']),
            'has_own_variant' => true,
        ];
    }
}
