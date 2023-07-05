<?php

namespace App\Models;

use App\Traits\HasTags;
use App\Models\Category;
use App\Traits\HasLikes;
use App\Models\ReplyAble;
use App\Traits\HasAuthor;
use App\Traits\HasReplies;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Thread extends Model implements ReplyAble, Viewable
{
    use HasFactory;
    use HasTags;
    use HasAuthor;
    use HasReplies;
    use HasLikes;
    use InteractsWithViews;

    const TABLE = 'threads';

    protected $table = self::TABLE;
    
    protected $fillable = [
        'title',
        'body',
        'slug',
        'category_id',
        'author_id',
    ];

    protected $with = [
        'authorRelation',
        'category',
        'tagsRelation',
        'likesRelation',
    ];
    
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function excerpt(int $limit = 100): string
    {
        return Str::limit(strip_tags($this->body()), $limit);
    }

    public function replyAbleSubject(): string
    {
        return $this->title();
    }

    public function id(): int
    {
        return $this->id;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function body(): string
    {
        return $this->body;
    }

    public function slug(): string
    {
        return $this->slug;
    }

    public function delete()
    {
        $this->removeTags();
        parent::delete();
    }

    public function scopeForTag(Builder $query, string $tag): Builder
    {
        return $query->whereHas('tagsRelation', function ($query) use ($tag) {
            $query->where('tags.slug', $tag);
        });
    }
}
