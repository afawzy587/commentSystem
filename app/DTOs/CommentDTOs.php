<?php

namespace App\DTOs;
use Spatie\LaravelData\Data;
class CommentDTOs extends Data
{
    /**
     * @var string|null
     */
    public ?string $id;

    /**
     * @var string
     */
    public string $comment;

    /**
     * @var string
     */
    public string $user_id;
}
