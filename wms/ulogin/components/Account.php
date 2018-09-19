<?php namespace Wms\Ulogin\Components;

use Cms\Classes\ComponentBase;
use Illuminate\Support\Facades\Redirect;
use October\Rain\Exception\ApplicationException;
use October\Rain\Support\Facades\Flash;
use October\Rain\Support\Facades\Str;
use RainLab\User\Facades\Auth;
use RainLab\User\Models\UserGroup;
use System\Models\File;
use Wms\Hunt\Components\AccountExt;
use Wms\Site\Models\Company;
use Wms\Site\Models\Country;

class Account extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'account Component',
            'description' => 'No description provided yet...'
        ];
    }



    private function login($user,$verify = -1)
    {
        if($verify == 1){
            $user = Auth::login($user,true);
        }else{
            AccountExt::sendActEmail($user);
            Flash::success('Мы отправили письмо для активации вашего аккаунта, проверьте вашу электронную почту, оно могло попасть папку спам');
        }
    }

    private function registration($data)
    {
        if($data['email']){
            $password = Str::random(6);
            $param = [
                'name' => $data['first_name'],
                'surname' => $data['first_name'],
                'email' => $data['email'],
                'password' => $password,
                'password_confirmation' => $password,
            ];

            if($data['verified_email'] == 1){
                $user = $this->registerUser($param,true);
                if(!empty($data['photo_big'])){
                    $avatar = $this->getAvatar($data['photo_big']);
                    $user->avatar()->add($avatar);
                    $user->save();
                }
                Auth::login($user);
                return $user;
            }else{
                $user = $this->registerUser($param,false);
                if(!empty($data['photo_big'])){
                    $avatar = $this->getAvatar($data['photo_big']);
                    $user->avatar()->add($avatar);
                    $user->save();
                }
                AccountExt::sendActEmail($user,false,$password);
                return $user;
            }
        }else{
            throw new ApplicationException('У вас должна быть привязана почта к аккаунту');
        }

    }

    public function getAvatar($url){
        $contents = file_get_contents($url);
        $temp = tmpfile();
        fwrite($temp, $contents);
        fseek($temp, 0);
        $name = substr($url, strrpos($url, '/') + 1);
        $name = explode('?',$name)[0];
        $avatar = new File();
        $avatar->fromData($temp, $name);
        $avatar->save();
        fclose($temp);
        return $avatar;
    }

    public function registerUser($param, $activate = false){
        $performer_group = UserGroup::where('code', 'performer')->first();
        $hunt_group = UserGroup::where('code', 'project-hunt')->first();
        $user = Auth::register($param,$activate);
        $user->groups()->add($performer_group);
        $user->groups()->add($hunt_group);
        $user->type = 0;
        $user->save();
        $this->makeCompany($user);
        return $user;
    }

    private function makeCompany($user)
    {
        $company = new Company();
        $company->name = $user->name . ' ' . $user->surname;
        $company->is_active = 0;
        $company->country_id = Country::where('name','Россия')->first()->id;
        $company->email = $user->email;
        $company->person_id = $user->id;
        $company->save();
    }

    private function sendVerifyAccount($email,$user){
        $vars = [
            'name' => $user->name,
            'link' => url('/').'?verify='
        ];
        Mail::send('wms.ulogin::mail.verify', $vars, function($message) use($otherSide){
            $message->to($email, 'Project Hunt');
        });
    }

    private function bindAccount($user,$data)
    {
        $account = new \Wms\Ulogin\Models\Account();
        $account->fill($data);
        $account->user_id = $user->id;
        $account->save();
    }

    public function defineProperties()
    {
        return [];
    }
}
