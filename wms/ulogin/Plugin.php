<?php namespace Wms\Ulogin;

use Backend;
use System\Classes\PluginBase;

/**
 * ulogin Plugin Information File
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
            'name'        => 'ulogin',
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

    public function registerSettings()
    {
        return [
            'settings' => [
                'label'       => 'Настройки Ulogin',
                'description' => 'Авторизация через социальные сети',
                'icon'        => 'icon-id-badge',
                'class'       => 'Wms\Ulogin\Models\Settings',
                'order'       => 500,
            ]
        ];
    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return [
            'Wms\Ulogin\Components\Ulogin' => 'Ulogin',
        ];
    }

    public function registerMailTemplates()
    {
        return [
            'wms.ulogin::mail.verify',
            'wms.ulogin::mail.plain.verify',
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
            'wms.ulogin.settings' => [
                'tab' => 'Авторизация через Ulogin',
                'label' => 'Доступ к настройкам Ulogin'
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
        return []; // Remove this line to activate

        return [
            'ulogin' => [
                'label'       => 'ulogin',
                'url'         => Backend::url('wms/ulogin/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['wms.ulogin.*'],
                'order'       => 500,
            ],
        ];
    }
}
