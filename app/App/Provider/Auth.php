<?php

namespace App\Provider;

use App\Model\User;
use Wiring\Service\Session;

class Auth extends User
{
    /**
     * Authentication check.
     *
     * @return bool
     */
    public function check()
    {
        return Session::exists(env('APP_AUTH_ID', 'user_id'));
    }

    /**
     * Get user authentication.
     *
     * @return \App\Model\User
     */
    public function user()
    {
        $userId = Session::get(env('APP_AUTH_ID', 'user_id'));

        return User::find($userId);
    }
}
