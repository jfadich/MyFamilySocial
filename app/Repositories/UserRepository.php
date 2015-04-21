<?php namespace MyFamily\Repositories;

use MyFamily\User;

class UserRepository extends Repository {

    /**
     *  Get all users
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        return User::all();
    }

    /**
     * Attempt to get category by Id, if not found search by slug
     *
     * @param $user
     * @return mixed
     */
    public function createUser($user)
    {
        return User::create($user);
    }

    public function findOrFail($user)
    {
        return User::findOrFail($user);
    }

    public function find($user)
    {
        return User::find($user);
    }

    public function search($term)
    {
        return User::where( 'first_name', 'like', '%' . $term . '%' )->get();
    }
}