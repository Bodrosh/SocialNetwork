<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostImage extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getUrlAttribute()
    {
        return url('storage/' . $this->path);
    }

    public static function clearStorage()
    {
        $images = PostImage::where('user_id', Auth::id())
            ->whereNull('post_id')->get();

        foreach ($images as $image) {
            Storage::disk('public')->delete($image->path);
            $image->delete();
        }
    }

    public static function setPostId($imageId, $postId)
    {
        if($imageId) {
            PostImage::find($imageId)->update(
                [
                    'post_id' => $postId
                ]
            );
        }
    }
}
