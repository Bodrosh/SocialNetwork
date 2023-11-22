<?php

namespace App\Http\Controllers;

use App\Http\Resources\Post\PostResource;
use App\Http\Resources\User\UserResourse;
use App\Models\Post;
use App\Models\SubscriberFollowing;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::WhereNot('id', Auth::id())->get();
        $users = User::withIsFollowedStatus($users);
        $users = UserResourse::collection($users)->resolve();

        return inertia('User/Index', compact('users'));
    }

    public function show()
    {
        return inertia('User/Show');
    }

    public function personal()
    {
       return inertia('User/Personal');
    }

    public function feed()
    {
        $followedIds = Auth::user()->followings()->get()->pluck('id')->toArray();

        $posts = Post::whereIn('user_id', $followedIds)->withCount('reposts')->latest()->get();
        $posts = Post::withIsLikedStatus($posts);
        $posts = Post::withLikesCount($posts);
        $posts = PostResource::collection($posts)->resolve();

        return inertia('User/Feed', compact('posts'));
    }
}
