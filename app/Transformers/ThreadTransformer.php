<?php namespace MyFamily\Transformers;

class ThreadTransformer extends Transformer {

    public function transform($thread)
    {
        return [
            'title' => $thread['title'],
            'body'  => $thread['body']
        ];
    }
}