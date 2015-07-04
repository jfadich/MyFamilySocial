<?php namespace MyFamily\Presenters;

class User extends Presenter
{
    protected $actionPaths = [
        'show' => 'UsersController@showUser',
    ];

    /**
     * Format the birthdate for display
     *
     * @param bool $timestamp
     * @return null
     * @internal param string $format
     */
    public function birthday( $timestamp = false )
    {
        $user   = $this->entity;
        if ( $user->birthdate !== null && $timestamp ) {
            return $user->birthdate->getTimestamp();
        }

        $format = $user->settings( 'birthday', 'full' );

        switch ( $format ) {
            case 'short':
                $format = 'F jS';
                break;
            case 'full':
                $format = 'F jS o';
                break;
        }

        if ( $user->birthdate !== null ) {
            return $user->birthdate->format( $format );
        }

        return null;
    }

    public function display_name()
    {
        $name   = '';
        $user = $this->entity;
        $format = $user->settings( 'display_name', 'full_name' );

        switch ( $format ) {
            case 'full_name':
                $name = ucwords( "{$user->first_name} {$user->last_name}" ); // "First Last"
                break;
            case 'last_initial':
                $name = ucwords( $user->first_name . ' ' . substr( $user->last_name, 0, 1 ) . '.' ); // "First L."
                break;
        }

        return $name;
    }

    public function email()
    {
        if ( $this->entity->settings( 'email', true ) ) {
            return $this->entity->email;
        }

        return null;
    }

    public function phone_one()
    {
        if ( $this->entity->settings( 'phone_one', true ) ) {
            return $this->entity->phone_one;
        }

        return null;
    }

    public function phone_two()
    {
        if ( $this->entity->settings( 'phone_two', true ) ) {
            return $this->entity->phone_two;
        }

        return null;
    }

    public function website()
    {
        if ( $this->entity->settings( 'website', true ) ) {
            return $this->entity->website;
        }

        return null;
    }

    public function address()
    {
        $user    = $this->entity;
        $address = [ ];

        switch ( $user->settings( 'address', 'full' ) ) {
            case 'full':
                $address = [
                    'street_address' => $user->street_address,
                    'city'           => $user->city,
                    'state'          => $user->state,
                    'zip_code'       => $user->zip_code
                ];
                break;
            case 'no_street':
                $address = [
                    'city'     => $user->city,
                    'state'    => $user->state,
                    'zip_code' => $user->zip_code
                ];
                break;
            case 'state_only':
                $address = [
                    'state' => $user->state
                ];
                break;
        }

        return $address;
    }

    public function profile_picture()
    {
        if ( $this->entity->profile_picture == null ) {
            return null;
        }

        return $this->getImageArray( $this->entity->profile_picture()->first() );
    }

    public function role()
    {
        $loggedIn = \JWTAuth::toUser();

        if ( $loggedIn->id !== $this->entity->id ) {
            return null;
        }

        return $this->entity->role()->with( [ 'permissions' ] )->first();
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