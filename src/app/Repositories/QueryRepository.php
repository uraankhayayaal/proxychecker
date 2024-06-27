<?php

namespace App\Repositories;

use App\Models\Query;
use Illuminate\Database\Eloquent\Builder;

class QueryRepository extends BaseApiRepository
{
    protected function getBuilder() : Builder
    {
        return Query::query();
    }
}