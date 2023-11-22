<?php
namespace App\Services\Post;

use App\Models\Comment;
use App\Models\Post;
use App\Models\PostImage;
use App\Models\Tag;
use App\Services\Tag\Service as TagService;
use Illuminate\Support\Facades\DB;

class Service
{
    public function getPosts()
    {
        $posts = Post::where('user_id', auth()->id())
            ->withCount('reposts')
            ->latest()
            ->get();

        return self::withLikes($posts);
    }

    public static function withLikes($posts)
    {
        $posts = Post::withIsLikedStatus($posts);
        return Post::withLikesCount($posts);
    }

    public function store(array $data)
    {
        try {
            DB::beginTransaction();

            $data['user_id'] = auth()->id();
            $imageId = $data['image_id'] ?? null;
            unset($data['image_id']);

            $post = Post::create($data);

            PostImage::setPostId($imageId, $post->id);
            PostImage::clearStorage();

            DB::commit();
            return $post;
        }
        catch (\Exception $exception) {
            DB::rollBack();
            return response()->json(['error' => $exception->getMessage()]);
        }
    }




}
