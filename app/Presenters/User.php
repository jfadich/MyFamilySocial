<?php namespace MyFamily\Presenters;

use Html;

class User extends Presenter
{
    /**
     * Format the birthdate for display
     *
     * @param string $format
     * @return null
     */
    public function birthday($format = 'F jS o')
    {
        // TODO Create user option to hide year
        // if($hideYear) $format = 'F jS';

        if ($this->entity->birthdate != null) {
            return $this->entity->birthdate->format( $format );
        }

        return null;
    }

    /**
     * Get the HTML image tag for the users profile picture. Give default if it's not set
     *
     * @param string $size
     * @param null $attributes
     * @return mixed
     */
    public function profile_picture($size = 'thumb', $attributes = null)
    {
        if (isset( $this->entity->profile_picture )) {
            $image_path = url( "images/{$size}/{$this->entity->profile_picture}" );
        } else {
            $image_path = url( "images/common/{$size}-default-profile.jpg" );
        }

        return Html::image( $image_path, $this->entity->first_name, $attributes );
    }

    /**
     * @return string
     */
    public function full_name()
    {
        return ucwords( "{$this->entity->first_name} {$this->entity->last_name}" );
    }

    /**
     * Generate the url to this entity
     *
     * @param string $action
     * @return string
     * @throws \MyFamily\Exceptions\PresenterException
     */
    public function url($action = 'show')
    {
        $this->setActionPaths( [
            'show' => 'UsersController@showUser',
            'edit' => 'UsersController@edit'
        ] );

        return parent::generateUrl( $action, $this->id );
    }

    /*
     * Title to be used when presenting photos attached to User
     */
    public function title()
    {
        return $this->first_name . "'s'" . ' profile';
    }

}