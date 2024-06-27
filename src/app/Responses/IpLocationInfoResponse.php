<?php

namespace App\Responses;

class IpLocationInfoResponse
{
    static public function success(
        string $ip,
        int $port,
        string $type,
        string $country,
        string $city,
        bool $status
        ) : array
    {
        return [
            'isOk' => true,
            'ip' => $ip,
            'port' => $port,
            'type' => $type,
            'country' => $country,
            'city' => $city,
            'status' => $status
        ];
    }

    static public function fail(
        string $address,
        string $message,
        ) : array
    {
        return [
            'isOk' => false,
            'address' => $address,
            'message' => $message,
        ];
    }
}
