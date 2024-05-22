<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Traits\UseFilters;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    use UseFilters;

    public function get(Request $request)
    {
        $commentsQuery = Comment::with(['replies'])
            ->where($this->getQueries())
            ->whereNull('comment_id')
            ->orderBy(...$this->getSorting());

        $this->paginate($commentsQuery);

        $comments = $commentsQuery->get();

        return response()->json(CommentResource::collection($comments));
    }

    public function store(StoreCommentRequest $request)
    {
        $comment = Comment::create([
            'user_id' => Auth::id(),
            'comment_id' => $request->comment_id ?? null,
            'reply_id' => $request->reply_id ?? null,
            'post_id' => $request->post_id,
            'text' => $request->text,
        ]);

        return response()->json(CommentResource::make($comment), 201);
    }
}
