<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface ReplyAble
{
    public function title(): string;

    public function replies();

    public function latestReplies(int $amount = 5);

    public function deleteReplies();

    public function repliesRelation(): MorphMany;

    public function isConversationOld(): bool;

    public function replyAbleSubject(): string;
}
