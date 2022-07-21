<?php

namespace Database\Factories\Polls;

use App\Lib\Thumbnail;
use App\Models\Polls\Poll;
use App\Models\Polls\PollCategory;
use App\Models\Polls\PollQuestion;
use App\Models\Polls\PollVariant;
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
            'label'       => 'Тестовый опрос',
            'description' => 'Прочитайте, пожалуйста, внимательно вопрос и отметьте тот вариант ответа, который считаете верным. Если Вы не нашли подходящего ответа среди предложенных, то напишите свой вариант.',
            'category_id' => PollCategory::factory(),
            'is_popular'  => true,
            'image'       => '/images/polls/8888.jpg',
            'thumbnail'   => Thumbnail::createSmall(public_path() . '/assets/images/polls/8888.jpg'),
        ];
    }

    public static function createPoliticsPoll()
    {

        $data = [
            'poll'      => [
                'sort'        => 1,
                'is_popular'  => true,
                'label'       => 'Опросный лист общественного мнения',
                'image'       => '/images/polls/8888.jpg',
                'thumbnail'   => Thumbnail::createSmall(public_path() . '/assets/images/polls/8888.jpg'),
                'description' => 'Прочитайте, пожалуйста, внимательно вопросы и отметьте тот вариант ответа, который считаете верным. Если Вы не нашли подходящего ответа среди предложенных, то укажите свой вариант.',
            ],

            'questions' => [
                [
                    'label'    => 'Знаете ли Вы, что 11 сентября 2022 года состоятся выборы депутатов в Органы местного самоуправления',
                    'sort'     => 1,
                    'variants' => [
                        'Да, знаю',
                        'Нет, не знаю',
                    ],
                ],
                [
                    'label'    => 'На каких выборах Вы последний раз принимали участие в голосовании? (любое число ответов)',
                    'sort'     => 2,
                    'type'     => 'checkbox',
                    'variants' => [
                        'Выборы депутатов Думы Ставропольского края (2021 года)',
                        'Выборы депутатов Государственной Думы Российской Федерации (2021 года)',
                        'Выборы губернатора Ставропольского края (2019 года)',
                        'Выборы Президента Российской Федерации (2018 года)',
                        'Не голосовал ещё ни разу',
                        'Не участвую в выборах более 5 лет',
                        'Не помню точно -  в каких выборах принимал участие в голосовании',
                    ],
                ],
                [
                    'label'    => 'Будете ли Вы голосовать на выборах депутатов в органы местного самоуправления 11 сентября 2022г.?',
                    'sort'     => 3,
                    'variants' => [
                        'Да',
                        'Еще не определился',
                        'Нет',
                    ],
                ],
                [
                    'label'    => 'Информацию каких местных телевизионных источников о жизни вашего города, села, поселка, хутора Вы считаете достоверными (доверяете)?',
                    'sort'     => 4,
                    'type'     => 'checkbox',
                    'variants' => [
                        'ГТРК «Ставрополье»',
                        '«Свое ТВ»',
                        [
                            'label'            => 'Другие телеканалы (укажите)',
                            'has_user_answer' => true,
                        ],
                    ],
                ],
                [
                    'label'    => 'Информацию каких местных газетных источников о жизни вашего города, села, поселка, хутора Вы считаете достоверными (доверяете)?',
                    'sort'     => 5,
                    'type'     => 'checkbox',
                    'variants' => [
                        '«Ставропольская правда»',
                        'Местная газета',
                        '«Вечерний Ставрополь»',
                        '«Комсомольская правда»',
                        '«МК-Кавказ»',
                        '«Ставропольские Ведомости»',
                        [
                            'label'            => 'Другая газета (укажите)',
                            'has_user_answer' => true,
                        ],
                    ],
                ],
                [
                    'label'            => 'Информацию каких местных радио-ресурсов о жизни вашего города, села, поселка, хутора Вы считаете достоверными (доверяете)?',
                    'sort'             => 6,
                    'type'             => 'checkbox',
                    'has_user_answer' => true,
                    'variants'         => [
                        'Радио «России»',
                        '«Вести ФМ»',
                        '«Дорожное радио»',
                        'Радио МИР',
                        [
                            'label'            => 'Другое радио (укажите)',
                            'has_user_answer' => true,

                        ],
                    ],
                ],
                [
                    'label'            => 'Информацию каких интернет источников о жизни вашего города, села, поселка, хутора Вы считаете достоверными (доверяете)?',
                    'sort'             => 7,
                    'type'             => 'checkbox',
                    'has_user_answer' => true,
                    'variants'         => [
                        'Информационное агентство «Победа-26»',
                        'Сетевое издание «Блокнот»',
                        'Сетевое издание «NewsTracker»',
                        'Город Ставрополь -1777.Ru ',
                        'Читаю блог',
                        [
                            'label'            => 'Пользуюсь другими интернет-источниками (укажите)',
                            'has_user_answer' => true,
                        ],
                    ],
                ],
                [
                    'label'    => 'Другие источники',
                    'sort'     => 8,
                    'variants' => [
                        'Достоверную информацию получаю на работе от руководителей и сослуживцев',
                        'Доверяю только информации полученной от друзей и знакомых',
                    ],
                ],
                [
                    'label'    => 'Что на Ваш взгляд, нужно сделать в городе, селе, поселке, хуторе, Вашем дворе, на Вашей улице для удобства жителей? (пожалуйста, продолжите фразу во втором пункте)',
                    'sort'     => 9,
                    'variants' => [
                        'Всё уже сделано',
                        [
                            'label'            => 'Необходимо сделать:',
                            'has_user_answer' => true,
                        ],
                    ],
                ],
                [
                    'label'    => 'Ваш пол?',
                    'sort'     => 10,
                    'variants' => [
                        'Мужской',
                        'Женский',
                    ],
                ],
                [
                    'label'    => 'Сколько Вам полных лет?',
                    'sort'     => 11,
                    'variants' => [
                        '18-29',
                        '30-49',
                        '50-59',
                        '60 и старше',
                    ],
                ],
                [
                    'label'    => 'Какое у Вас образование?',
                    'sort'     => 12,
                    'variants' => [
                        'Начальное',
                        'Среднее',
                        'Среднее специальное',
                        'Высшее (неоконченное высшее)',
                    ],
                ],
                [
                    'label'    => 'Где Вы проживаете?',
                    'sort'     => 13,
                    'variants' => [
                        'Многоквартирный дом',
                        'Частный дом',
                        'Среднее специальное',
                        'Общежитие',
                    ],
                ],
            ],

            'category'  => 'Общество',
        ];

        $data['poll']['category_id'] = PollCategory::create([
            'label' => $data['category'],
        ])['id'];

        $pollId = Poll::create($data['poll'])['id'];

        foreach ($data['questions'] as $params) {
            $questionId = PollQuestion::create([
                'label'   => trim($params['label']),
                'sort'    => $params['sort'],
                'type'    => $params['type'] ?? 'radio',
                'poll_id' => $pollId,

            ])['id'];

            foreach ($params['variants'] as $i => $variant) {
                PollVariant::create([
                    'label'            => is_array($variant) ? $variant['label'] : trim($variant),
                    'has_user_answer' => is_array($variant) ? $variant['has_user_answer'] : false,
                    'question_id'      => $questionId,
                    'sort'             => $i + 1,
                ]);
            }
        }
    }

    public static function createTestPoll()
    {

        $data = [
            'poll'      => [
                'sort'        => 1,
                'label'       => 'Тестовый опрос',
                'description' => 'Прочитайте, пожалуйста, внимательно вопросы и отметьте тот вариант ответа, который считаете верным. Если Вы не нашли подходящего ответа среди предложенных, то укажите свой вариант.',
            ],

            'questions' => [
                [
                    'label'    => 'Radio type test',
                    'sort'     => 1,
                    'variants' => [
                        'Да, знаю',
                        'Нет, не знаю',
                        [
                            'label'            => 'Свой вариант',
                            'has_user_answer' => true,
                        ],

                    ],
                ],
                [
                    'label'            => 'Checkbox test',
                    'sort'             => 2,
                    'type'             => 'checkbox',
                    'has_user_answer' => true,
                    'variants'         => [
                        '«Ставропольская правда»',
                        'Местная газета',
                        '«Вечерний Ставрополь»',
                        '«Комсомольская правда»',
                        '«МК-Кавказ»',
                        '«Ставропольские Ведомости»',
                        [
                            'label'            => 'Другая газета (укажите)',
                            'has_user_answer' => true,
                        ],
                    ],
                ],

                [
                    'label'       => 'Another Radio type test',
                    'description' => 'Test description here',
                    'sort'        => 3,
                    'variants'    => [
                        'Да, знаю',
                        'Нет, не знаю',
                    ],
                ],

                [
                    'label'       => 'Another checkbox test',
                    'description' => 'Test description here',
                    'sort'        => 4,
                    'type'        => 'checkbox',
                    'max_allowed' => 3,
                    'min_allowed' => 1,
                    'variants'    => [
                        '«Ставропольская правда»',
                        'Местная газета',
                        '«Вечерний Ставрополь»',
                        '«Комсомольская правда»',
                        '«МК-Кавказ»',
                        '«Ставропольские Ведомости»',
                    ],
                ],
            ],

            'category'  => 'Test category',
        ];

        $data['poll']['category_id'] = PollCategory::create([
            'label' => $data['category'],
        ])['id'];

        $pollId = Poll::create($data['poll'])['id'];

        foreach ($data['questions'] as $params) {
            $questionId = PollQuestion::create([
                'label'            => trim($params['label']),
                'sort'             => $params['sort'],
                'description'      => $params['description'] ?? null,
                'max_allowed'      => $params['max_allowed'] ?? 20,
                'min_allowed'      => $params['min_allowed'] ?? 1,
                'type'             => $params['type'] ?? 'radio',
                'poll_id'          => $pollId,

            ])['id'];

            foreach ($params['variants'] as $i => $variant) {
                PollVariant::create([
                    'label'            => is_array($variant) ? $variant['label'] : trim($variant),
                    'has_user_answer' => is_array($variant) ? $variant['has_user_answer'] : false,
                    'question_id'      => $questionId,
                    'sort'             => $i + 1,
                ]);
            }
        }
    }
}
