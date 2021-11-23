<?php

namespace App\Http\Helpers;

use App\Http\Controllers\Controller;

class AuthHelper extends Controller
{
    public static function checkUserLogged()
    {
        $logged = false;
        try {
            $logged = session()->exists('user') && session()->get('user')->logged === true;
        } catch (\Exception $e) {
            return false;
        }

        return $logged;
    }
}
