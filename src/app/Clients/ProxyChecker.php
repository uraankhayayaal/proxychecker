<?php

namespace App\Clients;

use App\Responses\IpInfoResponse;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ProxyChecker implements ClientInterface
{
    public const URL = 'https://proxycheck.io/v2/{ip}?vpn=1&asn=1';

    public function handle(string $ip, string $port)
    {
        try {
            $response = Http::timeout(3)->post(str_replace('{ip}', $ip, self::URL));

            if ($response->successful() && $response['status'] === 'ok')
            {
                return IpInfoResponse::success(
                    $ip,
                    $port,
                    $response[$ip]['type'],
                    $response[$ip]['country'],
                    $response[$ip]['city'],
                    $response[$ip]['proxy'] === 'yes',
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
            'The ProxyChecker server not allow'
        );
    }
}