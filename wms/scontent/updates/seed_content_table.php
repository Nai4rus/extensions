<?php namespace Wms\Scontent\Updates;

use October\Rain\Database\Updates\Seeder;
use Wms\Scontent\Models\Content;
use System\Models\File;

class SeedContentTable extends Seeder {
    public function run() {
//        0: Структура
//        1: Список
//        2: Заголовок
//        3: Текст
//        4: Изображение
//        5: Ссылка
//        6: Блок
//        "{base_path()}/themes/default/assets/"
        $data = array(
            [
                'title'        => 'Главная',
                'cms'          => 'index',
                'type_content' => 0,
                'type'         => 1,
                'children'     => [
                    'rating' => [
                        'title'        => 'Рейтинги',
                        'cms'          => 'index',
                        'type_content' => 0,
                        'type'         => 1,
                        'children'     => [
                            'title' => [
                                'type_content' => 2,
                                'raw_field'    => "DIGITAL-КОМПАНИЙ, \n которым можно доверять",
                            ],
                            'text'  => [
                                'type_content' => 3,
                                'raw_field'    => "Рейтинги помогают в выборе ведущих веб-студий, мобильных разработчиков, SEO-компаний, агентств контекстной рекламы и smm-агентств.",
                            ],
                            'items' => [
                                'type_content' => 1,
                                'children'     => [
                                    [
                                        'title'        => '15 независимых экспертов',
                                        'type_content' => 1,
                                        'children'     => [
                                            [
                                                'raw_field'    => "15",
                                                'type_content' => 2,
                                            ],
                                            [
                                                'raw_field'    => "независимых экспертов",
                                                'type_content' => 6,
                                            ],
                                        ]
                                    ],
                                    [
                                        'title'        => '297 компаний в рейтинге',
                                        'type_content' => 1,
                                        'children'     => [
                                            [
                                                'raw_field'    => "297",
                                                'type_content' => 2,
                                            ],
                                            [
                                                'raw_field'    => "компаний в рейтинге",
                                                'type_content' => 6,
                                            ],
                                        ]
                                    ],
                                    [
                                        'title'        => '75 охват городов',
                                        'type_content' => 1,
                                        'children'     => [
                                            [
                                                'raw_field'    => "75",
                                                'type_content' => 2,
                                            ],
                                            [
                                                'raw_field'    => "охват городов",
                                                'type_content' => 6,
                                            ],
                                        ]
                                    ],
                                ]
                            ]
                        ]
                    ],
                ]
            ],
            [
                'title'        => 'О проекте',
                'cms'          => 'about',
                'type_content' => 0,
                'type'         => 1,
                'children'     => [
                    'about' => [
                        'title'        => 'О проекте',
                        'cms'          => 'about',
                        'type_content' => 0,
                        'type'         => 1,
                        'children'     => [
                            'title' => [
                                'type_content' => 2,
                                'raw_field'    => "RuAwards - поможет выбрать надежное агентство",
                            ],
                            'text'  => [
                                'type_content' => 3,
                                'raw_field'    => "Удобный инструмент для выбора веб-студии, SEO-компании, мобильного разработчика, SMM-агентства и контекстной рекламы.",
                            ],
                            'items' => [
                                'type_content' => 1,
                                'children'     => [
                                    [
                                        'title'        => 'Более 30 рейтингов',
                                        'type_content' => 1,
                                        'children'     => [
                                            [
                                                'raw_field'    => "Более 30 рейтингов",
                                                'type_content' => 2,
                                            ],
                                            [
                                                'raw_field'    => "Детальный подбор компаний по ценовому сегменту, отрасли и расположению",
                                                'type_content' => 6,
                                            ],
                                        ]
                                    ],
                                    [
                                        'title'        => 'Прозрачная оценка',
                                        'type_content' => 1,
                                        'children'     => [
                                            [
                                                'raw_field'    => "Прозрачная оценка",
                                                'type_content' => 2,
                                            ],
                                            [
                                                'raw_field'    => "Наши эксперты проводят не зависимую аналитику компаний",
                                                'type_content' => 6,
                                            ],
                                        ]
                                    ],
                                    [
                                        'title'        => '№1 по возможности подбора',
                                        'type_content' => 1,
                                        'children'     => [
                                            [
                                                'raw_field'    => "№1 по возможности подбора",
                                                'type_content' => 2,
                                            ],
                                            [
                                                'raw_field'    => "Самая удобная система подбора агентства для решения Ваших задач",
                                                'type_content' => 6,
                                            ],
                                        ]
                                    ],
                                ]
                            ]
                        ]
                    ],
                ]
            ],
        );
        self::pars($data);

    }

    public function pars($contents, $parent = null) {
        foreach ($contents as $key => $content) {
            $item = new Content();
            if (!is_numeric($key)) {
                $item->code = $key;
            }
            if (isset($content['cms'])) {
                $item->cms = $content['cms'];
            }
            if (isset($content['type_content'])) {
                $item->type_content = $content['type_content'];
            }
            if (isset($content['title'])) {
                $item->title = $content['title'];
            }
            if (!empty($content['formatted_field'])) {
                $item->type = 1;
                $item->formatted_field = $content['formatted_field'];
            } elseif (!empty($content['raw_field'])) {
                $item->type = 0;
                $item->raw_field = $content['raw_field'];
            }
            $item->save();
            if (isset($content['image'])) {
                $file = new File();
                $file->fromFile(base_path() . "/themes/default/assets/" . $content['image']);
                $file->save();
                $item->image()->add($file);
            }
            if (!empty($parent)) {
                $item->parent()->add($parent);
            }
            $item->save();
            if (isset($content['children'])) {
                self::pars($content['children'], $item);
            }
        }
    }
}