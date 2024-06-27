<?php

namespace App\Services;

use App\Models\Post;
use App\Repositories\PostRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PostService
{
    public function __construct(private PostRepository $repository) {}

    public function getAll() : LengthAwarePaginator
    {
        return $this->repository->getAll();
    }

    public function delete(Post $model) : int
    {
        return $this->repository->delete($model);
    }

    public function create(array $params) : Post
    {
        return $this->repository->create($params);
    }

    public function update(Post $model, array $params) : Post
    {
        return $this->repository->update($model, $params);
    }

    public function incrementViews(Post $model) : Post
    {
        return $this->repository->update($model, [
            'views' => $model->views++,
        ]);
    }
}