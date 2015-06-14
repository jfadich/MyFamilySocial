<?php namespace MyFamily\Presenters;

class Photo extends Presenter
{
    protected $actionPaths = [
        'show'  => 'PhotosController@show',
        'image' => 'PhotosController@showPhoto'
    ];

    public function image()
    {
        return $this->getImageArray( $this->entity );
    }

    /**
     * @param string $action
     * @param null $parameters
     * @return string
     */
    public function url($action = 'show', $parameters = null)
    {
        if (is_null( $parameters ) || empty( $parameters )) {
            $parameters = [$this->id];
        } else {
            $parameters = [$parameters, $this->id];
        }

        return parent::generateUrl( $action, $parameters );
    }
}