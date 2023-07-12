<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'feed_id',
        'comment'
    ];

    public function feed() : BelongsTo {
        return $this->belongsTo(Feed::class);
    }

    function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }

}
