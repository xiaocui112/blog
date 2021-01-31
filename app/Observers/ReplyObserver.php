<?php

namespace App\Observers;

use App\Models\Reply;
use App\Notifications\TopicReplied;

class ReplyObserver
{
    public function created(Reply $reply)
    {
        $reply->topic->increment('reply_count', 1);
        $reply->topic->user->customNtify(new TopicReplied($reply));
    }
    public function creating(Reply $reply)
    {
        $reply->content = clean($reply->content, 'user_topic_body');
    }
    public function deleting(Reply $reply)
    {
        if ($reply->topic->reply_count == 0) {
            return;
        }
        $reply->topic->decrement('reply_count', 1);
    }
}
