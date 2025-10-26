<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Redirect;

class CommentController extends Controller
{
    public function store(Post $post)
    {
        $validated = request()->validate([
            'body' => 'required|string|max:2500|min:3',
        ]);

        Comment::create([
            ...$validated,
            'post_id' => $post->id,
            'user_id' => auth()->id(),
        ]);

        return Redirect::back()->banner('Comment created.');
    }

    public function update(Comment $comment)
    {
        $this->authorize('update', $comment);

        $comment->update(request()->validate([
            'body' => 'required|string|max:2500|min:3',
        ]));

        Redirect::back()->banner('Comment Updated.');
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return Redirect::back()->banner('Comment deleted.');
    }
}
