<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Reply;
use App\Models\ReplyAble;
use App\Events\ReplyWasCreated;
use App\Http\Requests\CreateReplyRequest;

class CreateReply
{
    private $body;
    private $author;
    private $replyAble;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $body, User $author, ReplyAble $replyAble)
    {
        $this->body = $body;
        $this->author = $author;
        $this->replyAble = $replyAble;
    }

    public static function fromRequest(CreateReplyRequest $request): self
    {
        return new static(
            $request->body(),
            $request->author(),
            $request->replyAble()
        );
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): Reply
    {
        $reply = new Reply(['body' => $this->body]);
        $reply->authoredBy($this->author);
        $reply->to($this->replyAble);
        $reply->save();

        event(new ReplyWasCreated($reply));

        return $reply;
    }
}
