<?php

namespace App\Responses;

class AuthResponse extends BaseApiResponse
{
    static public function logout()
    {
        return self::success([]);
    }

    static public function registred($token, $user)
    {
        return self::created(
            self::token($token, $user)
        );
    }

    static public function logined($token, $user)
    {
        return self::success(
            self::token($token, $user)
        );
    }

    static private function token($token, $user)
    {
        return [
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ];
    }
}