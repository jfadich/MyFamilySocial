<?php namespace MyFamily\Repositories;

use MyFamily\User;

class UserRepository extends Repository {

    /**
     *  Get all users
     *
     * @param null $count
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll( $count = null )
    {
        return User::with( $this->eagerLoad )->paginate( $count );
    }

    /**
     * Attempt to get category by Id, if not found search by slug
     *
     * @param $user
     * @return mixed
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