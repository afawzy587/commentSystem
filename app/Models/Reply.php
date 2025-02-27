<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reply extends Model
{

    use HasFactory;
    /**
     * @var string[]
     */
    protected $fillable = [
        'comment_id', 'user_id','reply_text',
    ];

    /**
     * @return BelongsTo
     */
    public function comment():BelongsTo
    {
        return $this->belongsTo(Comment::class);
    }

    /**
     * @return BelongsTo
     */

    public function User():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
