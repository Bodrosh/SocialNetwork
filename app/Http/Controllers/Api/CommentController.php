<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\GetByTagRequest;
use App\Http\Resources\Post\CommentResource;
use App\Models\Tag;
use App\Services\Comment\Service;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public $service;
    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    public function getByTag(GetByTagRequest $request)
    {
        $data = $request->validated();
        $comments = $this->service->getByTag($data['tag']);
        return CommentResource::collection($comments)->resolve();
    }
}
