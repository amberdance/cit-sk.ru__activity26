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
        'Поймал карандаш',
        'Z',
        'V',
        'Можем повторить',
        'Да',
        'Да',
        'Отрицательный рост',
        'Технологический суверенитет',
        'Хлопки газа',
        'Подтопление',
        'Задымление',
    ];

    public function definition()
    {
        return [
            'label'       => Arr::random($this->variants),
            'question_id' => PollQuestion::factory(),
        ];

    }
}
