<?php namespace MyFamily\Repositories;

use MyFamily\Activity;
use MyFamily\User;

class ActivityRepository extends Repository
{
    /**
     *  Get all users
     *
     * @param null $count
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getFeed( $count = null )
    {
        return Activity::select( \DB::raw( '*,count(id) as activity_count,max(created_at) created_at' ) )
            ->latest()->groupBy( 'name', 'owner_id', 'target_id',
                \DB::raw( 'date(created_at)' ) )
            ->orderBy( 'created_at', 'desc' )
            ->paginate( $this->perPage( $count ) );
    }

    public function getUserFeed( User $user, $count = null )
    {
        return $user->activity()->latest()->select( \DB::raw( '*,count(id) as activity_count' ) )
            ->groupBy( 'name', 'owner_id', 'target_id',
                \DB::raw( 'date(created_at)' ) )
            ->orderBy( 'created_at', 'desc' )
            ->paginate( $this->perPage( $count ) );
    }
}