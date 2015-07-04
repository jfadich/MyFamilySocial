<?php namespace MyFamily\Repositories;

use MyFamily\User;

class UserRepository extends Repository {

    protected $defaultOrder = [ 'created_at', 'desc' ];

    /**
     *  Get all users
     *
     * @param null $count
     * @param null $order
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll( $count = null, $order = null )
    {
        if ( $order === null ) {
            list( $orderCol, $orderBy ) = $this->defaultOrder;
        } else {
            list( $orderCol, $orderBy ) = $order;
        }

        return User::with( $this->eagerLoad )->orderBy( $orderCol, $orderBy )->paginate( $count );
    }

    /**
     * Attempt to get category by Id, if not found search by slug
     *
     * @param $newUser
     * @return mixed
     * @internal param $user
     */
    public function createUser( $newUser )
    {
        $user = new User( $newUser );

        $user->password = bcrypt( $newUser[ 'password' ] );
        $user->role_id  = 1;
        $user->save();

        return $user;
    }

    /**
     * @param $user
     * @return \MyFamily\User
     */
    public function findOrFail($user)
    {
        return User::with( $this->eagerLoad )->findOrFail( $user );
    }

    /**
     * @param $user
     * @return \MyFamily\User
     */
    public function find($user)
    {
        return User::with( $this->eagerLoad )->findOrFail( $user );
    }

    /**
     * @param $term
     * @return \MyFamily\User
     */
    public function search($term)
    {
        return User::with( $this->eagerLoad )->where( 'first_name', 'like', '%' . $term . '%' )->get();
    }
}