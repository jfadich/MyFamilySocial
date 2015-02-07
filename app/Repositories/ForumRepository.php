<?php namespace MyFamily\Repositories;

use MyFamily\ForumThread;

class ForumRepository extends Repository{

    public function getAllThreads($pageCount = 10)
    {
        return ForumThread::with('category', 'owner')->paginate($pageCount);
    }

    public function getThreadByCategory($categoryId, $pageCount = 10)
    {
        return ForumThread::with('owner')->where('category_id', '=', $categoryId)->paginate($pageCount);
    }

    public function getThread($thread)
    {
        if(is_numeric($thread))
            return ForumThread::findOrFail($thread)->first();

        return ForumThread::where('slug', '=', $thread)->with('replies')->first();
    }

    public function createThread($inputThread)
    {
        $thread = new ForumThread();
        $thread->body = $inputThread['message'];
        $thread->title = $inputThread['title'];
        $thread->category_id = $inputThread['category'];
        $thread->owner_id = \Auth::id();

        $thread->slug = $this->cleanSlug($thread->title);
        $thread->save();
        return $thread;
    }

}