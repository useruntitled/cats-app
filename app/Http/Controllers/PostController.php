<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {

    }

    public function latest(Request $request)
    {
        $page = $request->page;
        $posts = Post::latest()
            ->skip(($page - 1) * 5)
            ->take(5)
            ->get();

        return response()->json(PostResource::collection($posts));
    }
}
