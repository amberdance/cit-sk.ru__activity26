<?php

namespace Database\Factories\Polls;

use App\Models\Polls\PollCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PollFactory extends Factory
{

    protected static function newFactory()
    {
        return PollFactory::new ();
    }

    protected $labels = [
        'Жестка посадка',
        'На дворе 2022 год',
        'А тем временем',
        'Что сегодня на обед ?',
        'Времени на раскачку не осталось',
        'Когда доставят Xbox',
    ];

    public function definition()
    {
        return [
            'label'       => Arr::random($this->labels),
            'description' => $this->faker->text(rand(10, 100)),
            'category_id' => PollCategory::factory(),
            'image'       => __DIR__ . "/../../../public/assets/images/polls/Putin.jpg",
        ];
    }
}
