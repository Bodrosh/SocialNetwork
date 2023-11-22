<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $with = ['image', 'likedUsers', 'repostedPost', 'user'];
    protected $withCount = ['comments'];

    public function getDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function image(): HasOne
    {
        return $this->hasOne(PostImage::class )
            ->whereNotNull('post_id');
    }

    public function likedUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'liked_posts', 'post_id', 'user_id');
    }

    public function repostedPost(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'reposted_id', 'id');
    }

    public static function withIsLikedStatus($posts)
    {
        $likedPosts = Auth::user()->likedPosts()->withCount('reposts')->get(['post_id'])->pluck('post_id')->toArray();
        foreach ($posts as $post) {
            if (in_array($post->id, $likedPosts)) {
                $post->is_liked = true;
            }
        }
        return $posts;
    }

    public static function withLikesCount($posts)
    {
        foreach ($posts as $post) {
            $post->likes_count = $post->likedUsers->count();
        }

        return $posts;
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function reposts(): HasMany
    {
        return $this->hasMany(Post::class, 'reposted_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
