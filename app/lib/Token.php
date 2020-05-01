<?php

namespace app\lib;

class Token
{

    public static function generate()
    {
        return Session::put(Config::get('session/token_name'), md5(openssl_random_pseudo_bytes(32)));
    }

    public static function check($token)
    {
        $tokenName = Config::get('session/token_name');

        if (Session::exists($tokenName) && $token === Session::get($tokenName)) {
            Session::delete($tokenName);
            return true;
        }
        return false;
    }
}
