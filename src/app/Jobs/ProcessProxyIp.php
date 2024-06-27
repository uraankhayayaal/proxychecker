<?php

namespace App\Jobs;

use App\Clients\ClientInterface;
use App\Models\Proxy;
use App\Services\ProxyService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessProxyIp implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $uniqueFor = 3600;

    public function __construct(
        private Proxy $proxy
    ) {}

    public function uniqueId(): string
    {
        return $this->proxy->id;
    }

    public function handle(
        ProxyService $proxyService,
        ClientInterface $httpClient,
    ): void
    {
        $response = $httpClient->handle($this->proxy->ip, $this->proxy->port);
        
        if ($response['isOk']) {
            $proxyService->update($this->proxy, [
                'type' => $response['type'] ?? '-',
                'country' => $response['country'] ?? '-',
                'city' => $response['city'] ?? '-',
                'status' => $response['status'] ?? '-'
            ]);
        }
    }
}
