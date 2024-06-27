<?php

namespace App\Repositories;

use App\Models\Proxy;
use Illuminate\Database\Eloquent\Builder;

class ProxyRepository extends BaseApiRepository
{
    protected function getBuilder() : Builder
    {
        return Proxy::query();
    }
}