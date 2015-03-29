<?php namespace MyFamily\Presenters;

class Comment extends Presenter
{

    public function body($length = false)
    {
        if ($length) {
            return mb_strimwidth( $this->entity->body, 0, $length, '...' );
        }

        return $this->entity->body;
    }
}