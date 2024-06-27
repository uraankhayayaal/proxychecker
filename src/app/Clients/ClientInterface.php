<?php

namespace App\Clients;

interface ClientInterface
{
    public function handle(string $ip, string $port) : array;
}