<?php

namespace App\Services;

use App\Models\Query;
use App\Repositories\QueryRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class QueryService
{
    public function __construct(private QueryRepository $repository) {}

    public function getAll() : LengthAwarePaginator
    {
        return $this->repository->getAll();
    }

    public function delete(Query $model) : int
    {
        return $this->repository->delete($model);
    }

    public function create(array $params) : Query
    {
        return $this->repository->create($params);
    }

    public function update(Query $model, array $params) : Query
    {
        return $this->repository->update($model, $params);
    }
}