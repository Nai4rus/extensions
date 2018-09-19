<?php namespace Wms\Scontent;

use Backend;
use System\Classes\PluginBase;

/**
 * scontent Plugin Information File
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
            'name'        => 'scontent',
            'description' => 'No description provided yet...',
            'author'      => 'wms',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {

    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return []; // Remove this line to activate

        return [
            'Wms\Scontent\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {

        return [
            'wms.scontent.content' => [
                'tab' => 'Управление страницами',
                'label' => 'Управление страницами'
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {

        return [
            'scontent' => [
                'label'       => 'Управление страницами',
                'url'         => Backend::url('wms/scontent/contents'),
                'icon'        => 'icon-leaf',
                'permissions' => ['wms.scontent.content'],
                'order'       => 550,
            ],
        ];
    }
}
