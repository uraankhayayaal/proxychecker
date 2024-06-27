<?php

namespace App\Services;

use App\Clients\IpApi;
use App\Clients\ProxyChecker;
use App\Models\Query;

class ProxyCheckerService
{
    const IP_PATTERN = '/^\b(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?):\d{1,5}\b$/';

    public function __construct(
        private ProxyChecker $httpClient,
        // private IpApi $httpClient,
        private QueryService $queryService,
        private ProxyService $proxyService,
        private ProxyTestService $proxyTestService,
    ) {}

    public function queueToCheck(string $listOfProxies) : Query
    {
        $singleSpace = preg_replace('!\s+!', ' ', $listOfProxies);
        $addresses = explode(" ", $singleSpace);

        $error = false;

        foreach ($addresses as $address)
        {
            if (!preg_match(self::IP_PATTERN, $address))
            {
                $error = true;
            }
        }

        if ($error)
        {
            return redirect('/');
        }

        $query = $this->queryService->create([
            'addresses' => $listOfProxies
        ]);

        foreach ($addresses as $address)
        {
            [$ip, $port] = explode(':', $address);

            $response = $this->httpClient->handle($ip, $port);

            if ($response['isOk']) {
                $proxy = $this->proxyService->create([
                    'queryId' => $query->id,
                    'ip' => $response['ip'],
                    'port' => $response['port'],
                    'type' => $response['type'],
                    'country' => $response['country'],
                    'city' => $response['city'],
                    'status' => $response['status'],
                    'speed' => $response['speed'],
                    'timeout' => $response['timeout'],
                    'externalIp' => $response['externalIp'],
                ]);
            } else {
                $proxy = $this->proxyService->create([
                    'queryId' => $query->id,
                    'ip' => $ip,
                    'port' => $port
                ]);
            }

            $testResult = $this->proxyTestService->getSpeedAndTimeout($proxy);

            $proxy->status = $testResult['isConnected'];
            $proxy->speed = $testResult['speed'];
            $proxy->externalIp = $testResult['externalIp'];
            $proxy->save();
        }

        return $query;
    }
}