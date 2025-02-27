<?php

namespace App\Services\Comment;

use App\DTOs\CommentDTOs;
use App\Models\Comment;

class CommentService
{

    public function all()
    {
        return Comment::with('user','replies.user')->latest();
    }

    /**
     * @param CommentDTOs $commentDTOs
     * @return mixed
     */
    public function create(CommentDTOs $commentDTOs) : Comment
    {
        return Comment::create([
            'comment' => $commentDTOs->comment,
            'user_id' => $commentDTOs->user_id,
        ]);
    }



}
