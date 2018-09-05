<?php namespace Nai4rus\Extensions;

use Backend;
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
            'name'        => 'Extensions',
            'description' => 'No description provided yet...',
            'author'      => 'Nai4rus',
            'icon'        => 'icon-leaf'
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
        App::register('\Nai4rus\Extensions\Classes\Scaffold\ScaffoldServiceProvider');
    }
}
