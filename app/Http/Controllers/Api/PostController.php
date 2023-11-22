<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Post\CommentRequest;
use App\Http\Requests\Post\GetByTagRequest;
use App\Http\Requests\Post\RepostRequest;
use App\Http\Requests\Post\StoreRequest;
use App\Http\Resources\Post\CommentResource;
use App\Http\Resources\Post\PostResource;
use App\Models\Post;
use App\Models\Tag;
use App\Services\Comment\Service as CommentService;
use App\Services\Post\Service;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public Service $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $posts = $this->service->getPosts();
        return PostResource::collection($posts)->resolve();
    }

    public function getByTag(GetByTagRequest $request)
    {
        $data = $request->validated();

        $tag = Tag::where('title', $data['tag'])->first();
        $posts = Service::withLikes($tag->posts);

        return PostResource::collection($posts)->resolve();
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $post = $this->service->store($data);

        return PostResource::make($post)->resolve();
    }

    public function toggleLike(Post $post): array
    {
        $res = Auth::user()->likedPosts()->toggle($post->id);

        $data['is_liked'] = count($res['attached']) > 0;
        $data['likes_count'] = $post->likedUsers()->count();
        return $data;
    }

    public function repost(RepostRequest $request, Post $post)
    {
       $data = $request->validated();
       $data['user_id'] = auth()->id();
       $data['reposted_id'] = $post->id;

       Post::create($data);
    }

    public function commentList(Post $post)
    {
        $comments = CommentService::postComments($post);
        return CommentResource::collection($comments)->resolve();
    }

    public function comment(CommentRequest $request, Post $post)
    {
        $data = $request->validated();
        $comment = CommentService::createPostComment($data, $post);
        return CommentResource::make($comment)->resolve();
    }
}
