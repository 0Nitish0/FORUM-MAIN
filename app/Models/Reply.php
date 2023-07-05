<?php

namespace App\Models;

use App\Traits\HasLikes;
use App\Models\ReplyAble;
use App\Traits\HasAuthor;
use Illuminate\Support\Str;
use App\Traits\ModelHelpers;
use App\Traits\HasTimestamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reply extends Model
{
    use HasFactory;
    use HasAuthor;
    use HasTimestamps;
    use ModelHelpers;
    use HasLikes;

    const TABLE = 'replies';

    protected $table = self::TABLE;

    protected $fillable = [
        'body',
    ];
    
    protected $with = [
        'likesRelation',
    ];

    public function id(): int
    {
        return $this->id;
    }

    public function body(): string
    {
        return $this->body;
    }

    public function excerpt(int $limit = 200): string
    {
        return Str::limit(strip_tags($this->body()), $limit);
    }

    public function to(ReplyAble $replyAble)
    {
        return $this->replyAbleRelation()->associate($replyAble);
    }

    public function replyAble(): ReplyAble
    {
        return $this->replyAbleRelation;
    }

    public function replyAbleRelation(): MorphTo
    {
        return $this->morphTo('replyAbleRelation', 'replyable_type', 'replyable_id');
    }
}
