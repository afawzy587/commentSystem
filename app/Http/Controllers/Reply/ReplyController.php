<?php

namespace App\Http\Controllers\Reply;

use App\DTOs\ReplyDTOs;
use App\Http\Controllers\Controller;
use App\Services\Reply\ReplyService;
use App\Services\Comment\CommentService;
use App\Http\Requests\CreateReplyRequest;

class ReplyController extends Controller
{
    public function __construct(
        protected ReplyService $replyService,
        protected CommentService $commentService
    ) {
    }

    public function store(CreateReplyRequest $request)
    {
        $replyDto = ReplyDTOs::from($request->validated());

        $repliesCount = $this->replyService->commentRepliesCount($replyDto->comment_id);
        if ($repliesCount >= 5) {
            return response()->json([
                'status' => false,
                'message' => 'You can only reply to a comment 5 times.',
            ], 400);
        }
        $reply = $this->replyService->create($replyDto);

        return response()->json([
            'status' => true,
            'reply' => [
                'id' => $reply->id,
                'reply_text' => $reply->reply_text,
                'created_at' => $reply->created_at,
                'user' => [
                    'name' => $reply->user->name,
                ],
                'commentReplyCount' => $reply->id,
            ],
        ]);
    }
}
