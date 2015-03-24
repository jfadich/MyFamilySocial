<?php namespace MyFamily\Presenters;

use MyFamily\Exceptions\PresenterException;

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

    public function profile_picture($size = 'thumb', $attributes = null)
    {

        $attribute_string = $this->getAttributeString( $attributes );

        if (isset( $this->entity->profile_picture )) {
            $image_path = url( "images/{$size}/{$this->entity->profile_picture}" );
        } else {
            $image_path = url( "images/common/{$size}-default-profile.jpg" );
        }

        return "<img src=\"{$image_path}\" alt=\"{$this->entity->first_name}\" {$attribute_string}/>";
    }

    public function full_name()
    {
        return ucwords( "{$this->entity->first_name} {$this->entity->last_name}" );
    }

    public function url($action = 'show')
    {
        $this->setActionPaths( [
            'show' => 'ProfileController@showUser',
            'edit' => 'ProfileController@edit'
        ] );

        return parent::generateUrl( $action, $this->id );
    }

}