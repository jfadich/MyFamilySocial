<?php namespace MyFamily\Presenters;

class Album extends Presenter
{
    protected $actionPaths = [
        'show'   => 'AlbumsController@show',
        'create' => 'AlbumsController@create',
        'edit'   => 'AlbumsController@edit',
        'index'  => 'AlbumsController@index'
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