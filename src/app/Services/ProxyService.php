<?php

namespace App\Services;

use App\Models\Proxy;
use App\Repositories\ProxyRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProxyService
{
    public function __construct(private ProxyRepository $repository) {}

    public function getAll() : LengthAwarePaginator
    {
        return $this->repository->getAll();
    }

    public function delete(Proxy $model) : int
    {
        return $this->repository->delete($model);
    }

    public function create(array $params) : Proxy
    {
        return $this->repository->create($params);
    }

    public function update(Proxy $model, array $params) : Proxy
    {
        return $this->repository->update($model, $params);
    }
}