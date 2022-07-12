<?php

namespace Database\Factories\Polls;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PollCategoryFactory extends Factory
{
    protected static function newFactory()
    {
        return PollCategoryFactory::new ();
    }

    protected $categories = [
        'Солцеликий',
        'Величайший',
        'Политика',
        'Атмосфера',
        'Zдобрый вечер',
    ];

    public function definition()
    {
        return [
            'label' => Arr::random($this->categories),
        ];
    }
}
