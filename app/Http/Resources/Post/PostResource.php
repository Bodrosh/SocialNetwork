<?php

namespace App\Http\Resources\Post;

use App\Http\Resources\User\UserResourse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'date' => $this->date,
            'image_url' => $this->image->url ?? null,
            'is_liked' => $this->is_liked ?? null,
            'likes_count' => $this->likes_count ?? 0,
            'reposts_count' => $this->reposts_count ?? 0,
            'comments_count' => $this->comments_count ?? 0,
            'reposted_post' => $this->repostedPost ?
                RepostedPostResource::make($this->repostedPost)->resolve() : null,
            'user' => UserResourse::make($this->user)->resolve()
        ];
    }
}
