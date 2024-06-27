<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Responses\BaseResponse;
use App\Services\PostService;

class PostController extends Controller
{
    public function __construct(protected PostService $service) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return BaseResponse::json($this->service->getAll());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'photo' => 'required|string|max:255',
        ]);

        $post = $this->service->create([
            'title' => $request->title,
            'content' => $request->content,
            'photo' => $request->photo
        ]);

        return BaseResponse::created($post);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $post = $this->service->incrementViews($post);

        return BaseResponse::success($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'photo' => 'required|string|max:255',
        ]);
        
        $updatedPost = $this->service->update($post, [
            'title' => $request->title,
            'content' => $request->content,
            'photo' => $request->photo,
        ]);

        return BaseResponse::success($updatedPost);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        return BaseResponse::deleted($this->service->delete($post));
    }
}
