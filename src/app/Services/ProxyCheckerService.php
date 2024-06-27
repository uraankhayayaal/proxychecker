<?php

namespace App\Services;

use App\Jobs\ProcessProxyIp;
use App\Jobs\ProcessProxyTest;
use App\Models\Query;

/**
 * ProcessPodcast::dispatch()->onQueue('high');
 * php artisan queue:work --queue=high,default
 */
class ProxyCheckerService
{
    public function __construct(
        private QueryService $queryService,
        private ProxyService $proxyService,
    ) {}

    public function queueToCheck(Query $query) : void
    {
        $singleSpace = preg_replace('!\s+!', ' ', $query->addresses);
        $addresses = explode(" ", $singleSpace);

        foreach ($addresses as $address)
        {
            [$ip, $port] = explode(':', $address);

            $proxy = $this->proxyService->create([
                'queryId' => $query->id,
                'ip' => $ip,
                'port' => $port,
            ]);

            ProcessProxyIp::dispatch($proxy);

            ProcessProxyTest::dispatch($proxy);
        }
    }
}