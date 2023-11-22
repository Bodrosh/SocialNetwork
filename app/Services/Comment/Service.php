<?php
namespace App\Services\Comment;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use App\Services\Tag\Service as TagService;
use Illuminate\Support\Facades\DB;

class Service
{
    public function getByTag(string $tagTitle)
    {
        $tag = Tag::where('title', $tagTitle)->first();
        return $tag->comments;
    }

    public static function postComments(Post $post)
    {
        $comments = $post->comments()->latest()->get();
        foreach ($comments as $comment) {
            $comment->body = TagService::replaceTagsToLinks($comment->body);
        }

        return $comments;
    }

    public static function createPostComment(array $data, Post $post): Comment
    {
        $data['user_id'] = auth()->id();
        $data['post_id'] = $post->id;

        try {
            DB::beginTransaction();
            $comment = Comment::create($data);
            $tagIds = TagService::getTagIdsFromText($data['body']);
            $comment->tags()->sync($tagIds);
            DB::commit();

            $comment->body = TagService::replaceTagsToLinks($comment->body);
            return $comment;
        }
        catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception("create comment error " . $e->getMessage());
        }
    }
}
