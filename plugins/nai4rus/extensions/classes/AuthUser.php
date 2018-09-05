<?php
namespace Nai4rus\Extensions\Classes;

use October\Rain\Exception\ApplicationException;
use RainLab\User\Facades\Auth;

class AuthUser
{
    /**
     * @return mixed
     * @throws ApplicationException
     */
    public static function getUser() {
        if ($user = Auth::getUser()) {
            return $user;
        } else {
            throw new ApplicationException('Вы не авторизованы');
        }
    }
}
