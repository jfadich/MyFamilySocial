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
        return Activity::select( \DB::raw( '*,count(id) as activity_count,max(created_at) created_at' ) )->latest()->groupBy( 'owner_id',
            'name', 'target_id', \DB::raw( 'date(created_at)' ) )->orderBy( 'created_at',
            'desc' )->simplePaginate( 20 );
    }

    public function getUserFeed($user)
    {
        return $user->activity()->latest()->select( \DB::raw( '*,count(id) as activity_count' ) )->take( 5 )
            ->groupBy( 'target_type', 'target_id' )->get();
    }
}