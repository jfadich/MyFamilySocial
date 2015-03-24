<?php namespace MyFamily\Presenters;


class ForumCategory extends Presenter
{

    public function url($action = 'show')
    {
        $this->setActionPaths( [
            'show' => 'ForumController@threadsInCategory',
        ] );

        return parent::generateUrl( $action, $this->slug );
    }
}