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

    protected $variants = [
        'Безупречно ппоймал карандаш',
        'Z',
        'V',
        'Можем повторить',
        'Да',
        'Да',
        'Затрудняюсь ответить',
        'Отрицательный рост не наблюдается',
        'Технологический суверенитет набирает обороты',
        'Хлопки газа безопасны',
        'Подтопление не грозит человечеству',
        'Задымление подавлено',
    ];

    public function definition()
    {
        return [
            'label'       => Arr::random($this->variants),
            'question_id' => PollQuestion::factory(),
        ];

    }
}
