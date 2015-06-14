<?php namespace MyFamily\Presenters;

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

        if ( $this->entity->birthdate !== null ) {
            return $this->entity->birthdate->format( $format );
        }

        return null;
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
}