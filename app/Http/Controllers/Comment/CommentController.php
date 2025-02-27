<?php

namespace App\Http\Controllers\Comment;

use App\DTOs\CommentDTOs;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCommentRequest;
use App\Models\Comment;
use App\Services\Comment\CommentService;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    /**
     * @param CommentService $commentService
     */
    public function __construct(protected CommentService $commentService)
    {}

    public function index()
    {
        $comments = $this->commentService->all()->paginate(5);

        if (request()->ajax()) {
            return view('comments.partials.comments', compact('comments'))->render();
        }

        return view('comments.index', compact('comments'));
    }

    /**
     * @param CreateCommentRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateCommentRequest $request)
    {
        $commentDto = CommentDTOs::from($request->validated());
        $comment = $this->commentService->create($commentDto);

        return response()->json([
            'status' => true,
            'comment' => $comment,
            'encryptCommentId' => encrypt($comment->id),
            'user_name' => auth()->user()->name,
            'created_at' => $comment->created_at->format('d M Y'),
        ]);
    }


}
