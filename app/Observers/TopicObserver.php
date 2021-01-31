<?php

namespace App\Observers;

use App\Models\Topic;
use App\Handlers\SlugTranslateHandler;
use App\Jobs\TranslateSlug;

class TopicObserver
{
    /**
     * 在保存到数据库之前执行
     *
     * @param Topic $topic
     * @return void
     */
    public function saving(Topic $topic)
    {
        $topic->body = clean($topic->body, 'user_topic_body');
        $topic->excerpt = make_excerpt($topic->body);
    }
    public function saved(Topic $topic)
    {

        dispatch(new TranslateSlug($topic));
    }
    public function deleting(Topic $topic)
    {
        $topic->replies->delete();
    }
}
