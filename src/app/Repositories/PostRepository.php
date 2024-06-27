<?php

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;

class PostRepository extends BaseApiRepository
{
    protected function getBuilder() : Builder
    {
        return Post::query();
    }
}