<?php namespace Wms\Ulogin\Updates;

use October\Rain\Database\Updates\Seeder;
use Wms\Ulogin\Models\Settings;

class SeedSettings extends Seeder {
    public function run() {

        $settings = Settings::instance();
        $settings->display = 'small';
        $settings->theme = 'flat';
        $settings->providers_first = [
            array('social' => 'vkontakte'),
            array('social' => 'odnoklassniki'),
            array('social' => 'mailru'),
            array('social' => 'facebook')
        ];
        $settings->providers_second = [
            array('social' => 'other')
        ];
        $settings->save();
    }
}
