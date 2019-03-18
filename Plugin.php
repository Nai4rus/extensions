<?php namespace Nai4rus\Extensions;

use Backend;
use Illuminate\Support\Facades\Event;
use Nai4rus\Extensions\Classes\ListsTypes\Selector;
use Nai4rus\Extensions\Classes\ListsTypes\StrWords;
use Nai4rus\Extensions\Classes\ListColumnType;
use Nai4rus\Extensions\Classes\ListsTypes\Switcher;
use Nai4rus\Extensions\Classes\Scaffold\ScaffoldServiceProvider;
use Illuminate\Support\Facades\App;
use Nai4rus\Extensions\Classes\Helper;
use Nai4rus\Extensions\Components\Pages;
use System\Classes\PluginBase;

/**
 * extensions Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name' => 'Extensions',
            'description' => 'No description provided yet...',
            'author' => 'Nai4rus',
            'icon' => 'icon-leaf'
        ];
    }


    public function registerListColumnTypes(): array
    {
        return [
            'selector' => function ($value, $col, $model) {
                $listType = new Selector(new ListColumnType($value, $col, $model));
                return $listType->selector();
            },
            'strwords' => function ($value, $col) {
                $listType = new StrWords(new ListColumnType($value, $col));
                return $listType->strWords();
            },
            'slider' => function ($value, $col, $model) {
                $listType = new Switcher(new ListColumnType($value, $col, $model));
                return $listType->render();
            }
        ];
    }


    public function registerMarkupTags(): array
    {
        return [
            'functions' => [
                'prupal' => function ($number, $prupal) {
                    return Helper::prupals($number, $prupal);
                },
            ]
        ];
    }


    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {
        App::register(ScaffoldServiceProvider::class);

        Switcher::implement();
    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents(): array
    {
        return [
            Pages::class => 'Pages',
        ];
    }
}
