<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostsResource;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use App\Models\Post;
use App\Http\Requests\PostStoreRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PostUpdateRequest;

class PostController extends Controller
{

    public function index(): JsonResponse
    {
        return response()->json(PostsResource::collection(Post::all()));
    }

    public function store(PostStoreRequest $request): JsonResponse
    {
        $request->validated();
        $post_data = [
            'user_id' => Auth::user()->getAuthIdentifier(),
            'head' => $request->head,
            'text' => $request->text,
            'category_id' => $request->category_id,
        ];
        $created_post = Post::create($post_data);

        return response()->json(new PostResource($created_post));
    }

    public function show($id): JsonResponse
    {
        return response()->json(new PostResource(Post::findOrFail($id)));
    }

    public function update(PostUpdateRequest $request, Post $post): JsonResponse
    {
        $post->update($request->validated());

        return response()->json(new PostResource($post));
    }

    public function destroy($id): JsonResponse
    {
        Post::destroy($id);

        return response()->json(['message' => 'Post deleted successfully.']);
    }
}
