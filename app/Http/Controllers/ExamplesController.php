<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\Enums\Examples;

class ExamplesController extends Controller
{
    public function __invoke(Examples $example)
    {
        return $this->{'get'.$example->value}();
    }

    private function getPost()
    {
        return Post::factory()->withPostData(1)->raw()['body'];
    }

    private function getComment()
    {
        return Comment::factory()->withCommentData(1)->raw()['body'];
    }
}