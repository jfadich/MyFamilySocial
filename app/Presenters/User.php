<?php namespace MyFamily\Presenters;

class User extends Presenter
{
    protected $actionPaths = [
        'show' => 'UsersController@showUser',
    ];

    /**
     * Format the birthdate for display
     *
     * @param string $format
     * @return null
     */
    public function birthday($format = 'F jS o')
    {
        $format = $this->entity->settings( 'birthday', 'full' );

        switch ( $format ) {
            case 'short':
                $format = 'F jS';
                break;
            case 'full':
                $format = 'F jS o';
                break;
        }

        if ( $this->entity->birthdate !== null ) {
            return $this->entity->birthdate->format( $format );
        }

        return null;
    }

    public function display_name()
    {
        $name   = '';
        $format = $this->entity->settings( 'display_name', 'full_name' );

        switch ( $format ) {
            case 'full_name':
                $name = ucwords( "{$this->entity->first_name} {$this->entity->last_name}" );
                break;
            case 'last_initial':
                $name = ucwords( $this->entity->first_name . ' ' . substr( $this->entity->last_name, 0, 1 ) . '.' );
                break;
        }

        return $name;
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
        return parent::generateUrl( $action, $this->id );
    }
}