<?php

namespace App\Http\Controllers;

use App\Models\{Like};
use App\Services\LikeService;

class LikeController extends Controller
{
    public function __construct(protected LikeService $likeService) {}

    public function store(string $type, int $id)
    {
        $this->likeService
            ->can_be_liked_this($type)
            ->get_likable($type, $id)
            ->is_not_liked()
            ->like_it();
    }

    public function destroy(Like $like)
    {
        $this->authorize('delete', $like);

        $like->delete();
    }
}
