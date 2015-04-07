<?php namespace MyFamily\Repositories;

use MyFamily\Activity;

class ActivityRepository extends Repository
{

    /**
     *  Get all users
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getFeed()
    {
        return Activity::latest()->select( \DB::raw( '*,count(id) as activity_count' ) )->groupBy( 'owner_id',
            'name', 'target_id', \DB::raw( 'date(created_at)' ) )->simplePaginate( 20 );
    }

    public function getUserFeed($user)
    {
        return $user->activity()->select( \DB::raw( '*,count(id) as activity_count' ) )->take( 5 )->latest()
            ->groupBy( 'target_type', 'target_id' )->get();
    }
}