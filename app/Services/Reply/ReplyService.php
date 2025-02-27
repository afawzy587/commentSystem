<?php

namespace App\Services\Reply;

use App\DTOs\ReplyDTOs;
use App\Models\Comment;
use App\Models\Reply;

class ReplyService
{
    /**
     * @param ReplyDTOs $replyDTO
     * @return mixed
     */
    public function create(ReplyDTOs $replyDTO) : Reply
    {
        return Reply::create([
            'comment_id' => $replyDTO->comment_id,
            'reply_text' => $replyDTO->reply_text,
            'user_id' => $replyDTO->user_id,
        ]);
    }

    /**
     * @param int $commentId
     * @return mixed
     */
    public function commentRepliesCount(int $commentId)
    {
        return Reply::where('comment_id', $commentId)->count();
    }
}
