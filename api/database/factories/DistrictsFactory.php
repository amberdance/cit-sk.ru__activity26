<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class DistrictsFactory extends Factory
{
    private static $districts = [

        [
            "id"    => 735,
            "label" => "Кировский",
        ],
        [
            "id"    => 736,
            "label" => "Кисловодск",
        ],
        [
            "id"    => 747,
            "label" => "Петровский",
        ],
        [
            "id"    => 751,
            "label" => "Ставрополь",
        ],
        [
            "id"    => 755,
            "label" => "Шпаковский",
        ],
        [
            "id"    => 734,
            "label" => "Ипатовский",
        ],
        [
            "id"    => 739,
            "label" => "Курский",
        ],
        [
            "id"    => 743,
            "label" => "Невинномысск",
        ],
        [
            "id"    => 728,
            "label" => "Георгиевский",
        ],
        [
            "id"    => 733,
            "label" => "Изобильненский",
        ],
        [
            "id"    => 737,
            "label" => "Кочубеевский",
        ],
        [
            "id"    => 752,
            "label" => "Степновский",
        ],
        [
            "id"    => 754,
            "label" => "Туркменский",
        ],
        [
            "id"    => 742,
            "label" => "Минераловодский",
        ],
        [
            "id"    => 749,
            "label" => "Пятигорск",
        ],
        [
            "id"    => 745,
            "label" => "Новоалександровский",
        ],
        [
            "id"    => 740,
            "label" => "Левокумский",
        ],
        [
            "id"    => 741,
            "label" => "Лермонтов",
        ],
        [
            "id"    => 744,
            "label" => "Нефтекумский",
        ],
        [
            "id"    => 725,
            "label" => "Арзгирский",
        ],
        [
            "id"    => 726,
            "label" => "Благодарненский",
        ],
        [
            "id"    => 746,
            "label" => "Новоселицкий",
        ],
        [
            "id"    => 730,
            "label" => "Грачевский",
        ],
        [
            "id"    => 723,
            "label" => "Андроповский",
        ],
        [
            "id"    => 748,
            "label" => "Предгорный",
        ],
        [
            "id"    => 724,
            "label" => "Апанасенковский",
        ],
        [
            "id"    => 750,
            "label" => "Советский",
        ],
        [
            "id"    => 727,
            "label" => "Буденновский",
        ],
        [
            "id"    => 732,
            "label" => "Железноводск",
        ],
        [
            "id"    => 753,
            "label" => "Труновский",
        ],
        [
            "id"    => 731,
            "label" => "Ессентуки",
        ],
        [
            "id"    => 738,
            "label" => "Красногвардейский",
        ],
        [
            "id"    => 722,
            "label" => "Александровский",
        ],
    ];

    public function definition()
    {
        //
    }

    /**
     * @return void
     */
    public static function fillDistricts(): void
    {

        foreach (self::$districts as $district) {

            DB::table('districts')->insert($district);
        }

    }
}
