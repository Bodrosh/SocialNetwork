<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\PostImage\StoreRequest;
use App\Http\Resources\PostImage\PostImageResource;
use App\Models\PostImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostImageController extends Controller
{
    public function store(StoreRequest $request) {
        $data = $request->validated();
        try {
            $path = Storage::disk('public')
                ->put('/u/' . Auth::id() . '/images', $data['image']);
            $image = PostImage::create([
                'user_id' => Auth::id(),
                'path' => $path
            ]);
        }
        catch (\Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage()
            ]);
        }

        return PostImageResource::make($image)->resolve();
    }
}
