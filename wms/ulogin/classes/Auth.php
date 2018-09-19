<?php

namespace Wms\Ulogin\Classes;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use October\Rain\Exception\ApplicationException;
use RainLab\User\Models\User;
use RainLab\User\Facades\Auth as RainlabAuth;
use System\Models\File;

class Auth
{
    protected $authData = [];
    protected $user = [];

    /**
     * Auth constructor.
     * @param array $authData
     */
    public function __construct(array $authData)
    {
        $this->authData = $authData;
    }

    /**
     * @param array $authData
     * @return Auth
     */
    public static function instance(array $authData)
    {
        return new static($authData);
    }

    /**
     * @return mixed
     * @throws ApplicationException
     */
    public function checkAndGetUser()
    {
        $data = $this->authData;

        if (!isset($data['email'])) {
            throw new ApplicationException('У вас должна быть привязана почта к аккаунту');
        }

        return User::where('email', $data['email'])->first();
    }

    /**
     * @param User|null $user
     * @return bool
     * @throws ApplicationException
     */
    public function regOrLogin(User $user = null)
    {
        if (!$user) {
            $user = $this->checkAndGetUser();
        }

        if ($user) {
            $this->user = $user;
            return $this->login($user, $this->authData['verified_email']);
        }

        return $this->registration($this->authData);
    }

    /**
     * @param $user
     * @param bool $verified
     * @param bool $rememberUser
     * @return bool
     * @throws ApplicationException
     */
    protected function login($user, $verified = false, $rememberUser = true)
    {
        if ($verified == 1) {
            $user = RainlabAuth::login($user, $rememberUser);
            return $user;
        }

        static::sendVerificationMail($user);
        return false;
    }

    /**
     * @param $data
     * @return bool
     * @throws ApplicationException
     */
    protected function registration($data)
    {
        if(empty($data['email'])) {
            throw new ApplicationException('У вас должна быть привязана почта к аккаунту');
        }

        $password = Str::random(6);
        $param = [
            'name' => $data['first_name'],
            'surname' => $data['first_name'],
            'email' => $data['email'],
            'password' => $password,
            'password_confirmation' => $password,
        ];

        $is_verified = $data['verified_email'] == 1;

        $user = RainlabAuth::register($param,$is_verified);

        if(!empty($data['photo_big'])){
            $avatar = $this->getAvatar($data['photo_big']);
            if($avatar){
                $user->avatar()->add($avatar);
                $user->save();
            }
        }

        if($is_verified){
            RainlabAuth::login($user);
            return $user;
        }

        $this->sendVerificationMail($user,$password);
        return false;
    }

    /**
     * @param $url
     * @return File
     */
    protected function getAvatar($url){
        $contents = file_get_contents($url);
        $temp = tmpfile();
        fwrite($temp, $contents);
        fseek($temp, 0);
        $nameFile = basename(parse_url($url, PHP_URL_PATH));
        $avatar = new File();
        $avatar->fromData($temp, $nameFile);
        $avatar->save();
        fclose($temp);
        return $avatar;
    }

    /**
     * @param $user
     * @param null $password
     * @throws ApplicationException
     */
    protected function sendVerificationMail($user, $password = null)
    {
        try{
            $vars = [
                'user' => $user,
                'password' => $password,
                'link' => url('/') . '?verify='
            ];
            Mail::send(['wms.ulogin::mail.verify','wms.ulogin::mail.plain.verify'], $vars, function ($message) use ($user) {
                $message->to($user->email);
            });
        }catch (\Exception $exception){
            throw new ApplicationException('Не удалось отправить письмо для активации аккаунта');
        }

    }


}
