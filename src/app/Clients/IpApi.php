<?php

namespace App\Clients;

use App\Responses\IpInfoResponse;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class IpApi implements ClientInterface
{
    public const URL = 'http://ip-api.com/json/{ip}?fields=status,message,country,city,isp,reverse,proxy';

    public function handle(string $ip, string $port)
    {
        try {
            $response = Http::timeout(3)->post(str_replace('{ip}', $ip, self::URL));
            
            if ($response->successful() && $response['status'] === 'success')
            {
                return IpInfoResponse::success(
                    $ip,
                    $port,
                    '', // TODO: get type
                    $response['country'],
                    $response['city'],
                    $response['proxy'],
                    0, // TODO: get proxy speed
                    0, // TODO: get proxy timeout
                    '' // TODO: get external IP
                );
            }

            return IpInfoResponse::fail(
                $ip . ':' . $port,
                $response['message']
            );
        } catch (ConnectionException $e) {
            Log::error($e->getMessage(), ['code' => $e->getCode()]);
        }

        return IpInfoResponse::fail(
            $ip . ':' . $port,
            'The Pubproxy server not allow'
        );
    }
}