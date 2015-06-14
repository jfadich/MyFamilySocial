<?php namespace MyFamily\Presenters;


class Tag extends Presenter
{
    protected $actionPaths = [
        'show' => 'TagsController@show',
    ];

    /**
     * @param string $action
     * @return string
     * @throws \MyFamily\Exceptions\PresenterException
     */
    public function url($action = 'show')
    {
        return parent::generateUrl( $action, $this->slug );
    }
}