<?php namespace Wms\Ulogin\Components;

use Cms\Classes\ComponentBase;
use Illuminate\Support\Facades\Redirect;
use October\Rain\Support\Facades\Flash;
use Wms\Ulogin\Classes\Auth;
use Wms\Ulogin\Models\Settings;

class Ulogin extends ComponentBase
{
    public $settings;

    public function componentDetails()
    {
        return [
            'name'        => 'ulogin Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [
            'id' => [
                'title' => 'Подробная страница',
                'default' => 0,
                'type' => 'string'
            ]
        ];
    }

    public function onRun()
    {
        $this->addJs('assets/js/socialAuth.js');
        $this->addJs('//ulogin.ru/js/ulogin.js');
        $this->setSettings();
    }

    protected function setSettings(){
        $settings = Settings::instance()->attributes;

        if(isset($settings['providers_first'])){
            $settings['providers_first'] = array_flatten($settings['providers_first']);
        }

        if(isset($settings['providers_second'])){
            $settings['providers_second'] = array_flatten($settings['providers_second']);
        }
        $this->settings = $settings;
    }


    public function onSocialAuth()
    {
        $data = post('data');
        $user = Auth::instance($data)->regOrLogin();

        if($user === false){
            Flash::success('Мы отправили письмо для активации вашего аккаунта, проверьте вашу электронную почту, оно могло попасть папку спам');
        }

        Flash::success('Вы успешно авторизовались!');

        return Redirect::refresh();
    }




}
