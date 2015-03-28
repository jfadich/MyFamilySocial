<?php namespace MyFamily\Presenters;

class Photo extends Presenter
{

    /**
     * @param string $action
     * @param null $parameters
     * @return string
     */
    public function url($action = 'show', $parameters = null)
    {
        $this->setActionPaths( [
            'show'  => 'PhotosController@show',
            'edit'  => 'PhotosController@edit',
            'image' => 'PhotosController@showPhoto'
        ] );

        return parent::generateUrl( $action, [$parameters, $this->id] );
    }
}