<?php

namespace Database\Factories\Polls;

use App\Lib\Thumbnail;
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

    protected $images = [
        "/images/polls/Putin.jpg",
        "/images/polls/1575.jpg",
        "/images/polls/5h4YhDFNw4E.jpg",
        "/images/polls/7zRZR4Dna-k.jpg",
        "/images/polls/8RXOuIsU5O0.jpg",
        "/images/polls/1024px-Operation_Upshot-Knothole_-_Badger_001.jpg",
    ];

    public function definition()
    {

        $image = Arr::random($this->images);

        return [
            'label'       => Arr::random($this->labels),
            'description' => $this->faker->text(rand(10, 100)),
            'category_id' => PollCategory::factory(),
            'image'       => $image,
            'thumbnail'   => Thumbnail::createSmall(public_path() . "/assets/" . $image, public_path() . "/assets/images/polls/thumbnails"),
        ];
    }
}
