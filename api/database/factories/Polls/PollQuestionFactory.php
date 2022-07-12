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

    protected $questions = [
        'Чем славится Солцеликий ?',
        'Путин - президент мира ?',
        'Стоит ли пить пиво без закусок ?',
        'Как правильно затягивать пояса потуже ?'
    ];

    public function definition()
    {
        return [
            'poll_id' => Poll::factory(),
            'label'   => Arr::random($this->questions),
        ];
    }
}
