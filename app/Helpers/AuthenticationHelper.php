<?php

namespace App\Helpers;

use App\Models\User;

class AuthenticationHelper
{

    public static function isLogged($api_token)
    {
        $user = User::where('api_token', $api_token)->first();
        if(!$user) return false;
        return true;
    }

    public static function isLoggedUser($api_token)
    {
        $user = User::where('api_token', $api_token)->first();
        if(!$user) return false;
        return $user;
    }

    public static function isAdmin($api_token)
    {
        $user = User::where('api_token', $api_token)->first();
        if($user->is_admin == 1) return 1;
        return 0;
    }

    public static function AuthenticatedUser($api_token)
    {
        return User::where('api_token', $api_token)->first();
    }

    public static function AuthenticatedUserId($api_token)
    {
        return User::where('api_token', $api_token)->first()->id;
    }
}

