<?php

namespace App\DTOs;
use Spatie\LaravelData\Data;
class ReplyDTOs extends Data
{
    /**
     * @var string|null
     */
    public ?string $id;

    /**
     * @var string
     */
    public string $comment_id;

    /**
     * @var string
     */
    public string $user_id;

    /**
     * @var string
     */
    public string $reply_text;
}
