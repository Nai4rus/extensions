<?php namespace Nai4rus\Extensions;

use Backend;
use Nai4rus\Extensions\Classes\ListsTypes\Selector;
use Nai4rus\Extensions\Classes\ListsTypes\StrWords;
use Nai4rus\Extensions\Classes\ListColumnType;
use October\Rain\Support\Facades\Str;
use System\Classes\PluginBase;
use Illuminate\Support\Facades\App;
use Nai4rus\Extensions\Classes\Helper;
use Carbon\Carbon;

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

    public function registerListColumnTypes()
    {
        return [
            'selector' => function ($value, $col, $model) {
                $listType = new Selector(new ListColumnType($value, $col, $model));
                return $listType->selector();
            },
            'strwords' => function ($value, $col) {
                $listType = new StrWords(new ListColumnType($value, $col));
                return $listType->strWords();
            }
        ];
    }

    public function registerMarkupTags()
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
        Carbon::setLocale(config('app.locale'));
        App::register('\Nai4rus\Extensions\Classes\Scaffold\ScaffoldServiceProvider');
    }
}
