<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserStatsRequest;
use App\Http\Resources\Post\PostResource;
use App\Models\LikePost;
use App\Models\Post;
use App\Models\SubscriberFollowing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function posts(User $user)
    {
        $posts = Post::withIsLikedStatus($user->posts);
        $posts = Post::withLikesCount($posts);

        return PostResource::collection($posts)->resolve();
    }

    public function toggleFollowing(User $user)
    {
        $res = Auth::user()->followings()->toggle($user->id);
        return count($res['attached']) > 0;
    }

    public function stat(UserStatsRequest $request)
    {
        $data = $request->validated();
        $userId = isset($data['user_id']) ? $data['user_id'] : auth()->id();
        $stats = [];
        $stats['subscribers_count'] = SubscriberFollowing::where('following_id', $userId)->count();
        $stats['followings_count'] = SubscriberFollowing::where('subscriber_id', $userId)->count();

        $userPostsIds = Post::where('user_id', $userId)->get()->pluck('id')->toArray();
        $stats['likes_count'] = LikePost::whereIn('post_id', $userPostsIds)->count();
        $stats['posts_count'] = count($userPostsIds);

        return response()->json($stats);
    }
}
