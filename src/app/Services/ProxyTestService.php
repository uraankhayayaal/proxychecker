<?php

namespace App\Services;

use App\Models\Proxy;
use Illuminate\Support\Facades\Log;

class ProxyTestService
{
    const URL = 'https://api.ipify.org?format=json';

    public function getSpeedAndTimeout(Proxy $proxy) : array
    {
        try {
            $loadtime = time();

            $response = $this->curl($proxy->ip, $proxy->port);

            $speed = time() - $loadtime; // TODO: Calculate

            if ($response === false) {
                Log::error('Proxy dosent connect');
            } else {
                return [
                    'isConnected' => true,
                    'speed' => $speed,
                    'externalIp' => json_decode($response, true)['ip'],
                ];
            }
        } catch (\Throwable $th) {
            throw $th;
        }

        return [
            'isConnected' => false,
            'speed' => null,
            'externalIp' => null,
        ];
    }

    private function curl($ip, $port)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::URL);
        curl_setopt($ch, CURLOPT_PROXY, "$ip:$port");
        //curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyauth);
        curl_setopt($ch, CURLOPT_HEADER, 0); // return headers 0 no 1 yes
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return page 1:yes
        curl_setopt($ch, CURLOPT_TIMEOUT, 200); // http request timeout 20 seconds
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Follow redirects, need this if the url changes
        curl_setopt($ch, CURLOPT_MAXREDIRS, 2); //if http server gives redirection responce
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
            'Accept-Language: en-US,en;q=0.5',
            'Accept-Encoding: gzip, deflate',
            'Connection: keep-alive',
            'Upgrade-Insecure-Requests: 1'
        ]);
        curl_setopt($ch, CURLOPT_COOKIEJAR, "cookies.txt"); // cookies storage / here the changes have been made
        curl_setopt($ch, CURLOPT_COOKIEFILE, "cookies.txt");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // false for https
        curl_setopt($ch, CURLOPT_ENCODING, "gzip"); // the page encoding
        $curl_scraped_page = curl_exec($ch);
        curl_close($ch);

        return $curl_scraped_page;
    }
}