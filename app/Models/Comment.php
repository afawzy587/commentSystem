<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable =
        [
            'comment',
            'user_id',
        ];

    /**
     * @return HasMany
     */

    public function replies():HasMany
    {
        return $this->hasMany(Reply::class)->latest();
    }

    /**
     * @return BelongsTo
     */

    public function User():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
