<?php

namespace App\Http\Controllers;

use App\Http\Requests\PublishPostRequest;
use App\Http\Resources\PostResource;
use App\Models\Media;
use App\Models\Post;
use App\Models\Scopes\PublishedScope;
use App\Policies\PostPolicy;
use App\Traits\UseFilters;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    use UseFilters;

    public function index($id)
    {
        $post = Post::with(['media', 'user'])
            ->findOrFail($id);

        return response()->json(PostResource::make($post));
    }

    public function get(Request $request)
    {
        $query = Post::with('media')
            ->withCount('comments')
            ->orderBy(...$this->getSorting())
            ->where($this->getQueries());

        $this->paginate($query);

        $posts = $query->get();

        return response()->json(PostResource::collection($posts));
    }

    public function store(Request $request)
    {
        $post = Post::create([
            'title' => $request->title ?? '',
            'user_id' => auth()->user()->id,
        ]);

        return response()->json($post, 201);
    }

    public function publish(PublishPostRequest $request)
    {
        $post = Post::withoutGlobalScope(PublishedScope::class)
            ->findOrFail($request->id);

        Gate::authorize(PostPolicy::PUBLISH, $post);

        $post->update([
            'title' => $request->title,
            'published_at' => now(),
        ]);

        $post->media()->save(Media::findOrFail($request->media['uuid']));

        return response()->json('', 200);
    }
}
