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

        if (is_null( $parameters ) || empty( $parameters )) {
            $parameters = [$this->id];
        } else {
            $parameters = [$parameters, $this->id];
        }

        return parent::generateUrl( $action, $parameters );
    }

    /*
    * Title to be used when presenting photos attached to User
    */
    public function title()
    {
        return $this->name;
    }
}