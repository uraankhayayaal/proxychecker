<?php

namespace App\Responses;

class IpInfoResponse
{
    static public function success(
        string $ip,
        int $port,
        string $type,
        string $country,
        string $city,
        bool $status,
        string $speed,
        float $timeout,
        string $externalIp,
        ) : array
    {
        return [
            'isOk' => true,
            'ip' => $ip,
            'port' => $port,
            'type' => $type,
            'country' => $country,
            'city' => $city,
            'status' => $status,
            'speed' => $speed,
            'timeout' => $timeout,
            'externalIp' => $externalIp,
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
