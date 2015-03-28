<?php namespace MyFamily\Presenters;


class Album extends Presenter
{
    /**
     * @param string $action
     * @return string
     * @throws \MyFamily\Exceptions\PresenterException
     */
    public function url($action = 'show')
    {
        $this->setActionPaths( [
            'show'  => 'AlbumsController@show',
            'index' => 'AlbumsController@index'
        ] );

        return parent::generateUrl( $action, $this->id );
    }
}