<?php

namespace App\Jobs;

use App\Clients\ClientInterface;
use App\Models\Proxy;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessProxyTest implements ShouldQueue, ShouldBeUnique
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

    public function handle(ClientInterface $httpClient): void
    {
        $testResult = $httpClient->handle($this->proxy->ip, $this->proxy->port);

        $this->proxy->status = $testResult['isConnected'];
        $this->proxy->speed = $testResult['speed'] ?? -1;
        $this->proxy->speed = $testResult['timeout'] ?? -1;
        $this->proxy->externalIp = $testResult['externalIp'] ?? '-';
        $this->proxy->save();
    }
}
